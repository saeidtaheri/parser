<?php

namespace App\Providers;

use DateTime;
use stdClass;

class DataProvider
{
    private array $data;

    public function fromCsv(): self
    {
        $csv_provider = array_map('str_getcsv', file(getcwd() . '/data/users.csv'));
        array_walk($csv_provider, function (&$a) use ($csv_provider) {
            $a = array_combine($csv_provider[0], $a);
        });
        array_shift($csv_provider); # Remove header column

        $this->data[] = $csv_provider;

        return $this;
    }

    public function fromUrl(): self
    {
        $url = 'https://randomuser.me/api/?inc=gender,name,email,location&results=5&seed=a9b25cd955e2035f';
        $web_provider = json_decode(file_get_contents($url))->results;

        $users = [];
        $i = 100000000000;
        foreach ($web_provider as $item) {
            $i++;
            if ($item instanceof stdClass) {
                $users[] = [
                    'id' => $i,
                    'gender' => $item->gender,
                    'name' => $item->name->first . ' ' . $item->name->last,
                    'country' => $item->location->country,
                    'postcode' => $item->location->postcode,
                    'email' => $item->email,
                    'birthdate' => (new DateTime('now'))->format(DateTime::RFC3339)
                ];
            }
        }

        $this->data[] = $users;

        return $this;
    }

    public function prepare(): array
    {
       return call_user_func_array('array_merge', $this->data);
    }
}