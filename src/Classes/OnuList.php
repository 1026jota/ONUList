<?php

namespace Jota\OnuList\Classes;

use Goutte\Client;

class OnuList
{
    /**
     * name to search
     * @var string
     */
    private string $name;

    /**
     * result to search
     * @var array
     */
    private array $result;


    private function initData()
    {
        $this->result['is_registered'] = false;
        $this->result['total_results'] = 0;
        $this->result['result'] = [];
    }

    /**
     * search by specific names into onu list
     * @param string $name
     * @return void
     */
    public function searchByName(string $name): void
    {
        $this->initData();
        $this->name = strtolower($name);
        $client = new Client();
        $crawler = $client->request('GET', config('onulist.url'));
        $crawler->filter('[class="rowtext"]')->each(function ($data) {
            $split = explode('Name:', $data->text());
            if (strcmp(str_replace(' ', '', $this->name), $this->makeName($split)) == 0) {
                $info = [
                    'name' => $this->name,
                ];
                $this->result['is_registered'] = true;
                $this->result['total_results'] += 1;
                $this->result['result'] = $info;
            }
        });
    }

    /**
     * search all names into onu list
     */
    public function searchAll(): void
    {
        $this->initData();
        $client = new Client();
        $crawler = $client->request('GET', config('onulist.url'));

        $crawler->filter('[class="rowtext"]')->each(function ($data) {
            $split = explode('Name:', $data->text());
            $info = [
                'name' => $this->makeName($split),
            ];
            $this->result['total_results'] += 1;
            array_push($this->result['result'], $info);
        });
    }

    /**
     * recibe a array and clean for make a Name
     * @return string
     */
    private function makeName(array $split): string
    {
        $split_names = explode(':', $split[1]);

        $first = substr($split_names[1], 0, -2);
        $first = substr($first, 1);

        $second = substr($split_names[2], 0, -2);
        $second = substr($second, 1);

        $third = substr($split_names[3], 0, -2);
        $third = substr($third, 1);
        $third = rtrim($third, 'na ');

        $fourth = rtrim($split_names[4], 'Name (original script)');
        $fourth = rtrim($fourth, 'na Title');
        $fourth = substr($fourth, 1);
        $fourth = substr($fourth, 0, -1);

        $name = $first . ' ' . $second;
        if ($third !== '')
            $name .= ' ' . $third;
        if ($fourth !== '')
            $name .= ' ' . $fourth;
        return str_replace(' ', '', strtolower($name));
    }

    /**
     * Return a search result in json form
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }
}
