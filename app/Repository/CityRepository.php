<?php

namespace Frederico\Weather\App\Repository;

use Frederico\Weather\App\Domain\City;
use PDO;

class CityRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(City $city): City
    {
        $sql = "INSERT INTO city(id, latitude, longitude, country) VALUES (?,?,?,?)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$city->id, $city->latitude, $city->longitude, $city->country]);
        return $city;
    }

    public function findById(string $id): ?City
    {

        $sql = "SELECT id, latitude, longitude, country FROM city WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $city = new City();
                $city->id = $row['id'];
                $city->latitude = $row['latitude'];
                $city->longitude = $row['longitude'];
                $city->country = $row['country'];
                return $city;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function findAll(): ?array
    {
        $sql = "SELECT id, latitude, longitude, country FROM city";
        $statement = $this->connection->query($sql);

        $result = [];

        foreach ($statement as $row) {
            $city = new City();
            $city->id = $row['id'];
            $city->latitude = $row['latitude'];
            $city->longitude = $row['longitude'];
            $city->country = $row['country'];

            $result[] = $city;
        }

        if ($result) {
            return $result;
        } else {
            return null;
        }
    }


    public function findSearchId($data): ?array
    {
        $sql = "SELECT id FROM city WHERE id like '%" . $data . "%' ";
        $statement = $this->connection->query($sql);

        $result = [];

        foreach ($statement as $row) {
            $city = new City();
            $city->id = $row['id'];
            $result[] = $city;
        }

        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    public function deleteAll(): void
    {
        $this->connection->exec("DELETE FROM city");
    }
}
