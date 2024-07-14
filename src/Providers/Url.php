<?php

namespace App\Providers;

use App\Contracts\DataProviderInterface;
use DateTime;
use DateTimeInterface;
use stdClass;

class Url implements DataProviderInterface
{
    /**
     * @return array
     */
    public function provide(): array
    {
        $webProvider = json_decode(file_get_contents('./data/network.json'))->results;

        $users = [];
        $id = 100000000000;
        foreach ($webProvider as $item) {
            $id++;
            if ($item instanceof stdClass) {
                $users[] = [
                    'id' => $id,
                    'gender' => $item->gender,
                    'name' => "{$item->name->first} {$item->name->last}",
                    'country' => $item->location->country,
                    'postcode' => $item->location->postcode,
                    'email' => $item->email,
                    'birthdate' => (new DateTime('now'))
                        ->format(DateTimeInterface::RFC3339)
                ];
            }
        }

        return $users;
    }
}
