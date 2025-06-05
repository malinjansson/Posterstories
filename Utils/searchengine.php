<?php
require_once("vendor/autoload.php"); 
require_once("Models/Product.php"); 

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

require_once("Models/Database.php"); 

$dotenv = Dotenv\Dotenv::createImmutable("."); 
$dotenv->load();


class SearchEngine{
    private $accessKey;
    private $secretKey;
    private $url;
    private $index_name;

    private  $client;

    function __construct(){

        $this->accessKey = $_ENV['ACCESS_KEY'];
        $this->secretKey = $_ENV['SECRET_KEY'];
        $this->url = $_ENV['URL'];
        $this->index_name = $_ENV['INDEX_NAME'];


        $this->client = new Client([
            'base_uri' => $this->url,
            'verify' => false,
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->accessKey . ':' . $this->secretKey),
                'Content-Type' => 'application/json'
            ]
        ]);

    }

    function getDocumentIdOrUndefined(string $webId): ?string {
        $query = [
            'query' => [
                'term' => [
                    'webid' => $webId
                ]
            ]
        ];


        try {
            $response = $this->client->post("/api/index/v1/{$this->index_name}/_search", [
                'json' => $query
            ]);

            $data = json_decode($response->getBody(), true);

            if (empty($data['hits']['total']['value'])) {
                return null;
            }

            return $data['hits']['hits'][0]['_id'];
        } catch (RequestException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    function search(string $query,string $sortCol, string $sortOrder){
        $q = $query . '*';
        $query = [
            'query' => [
                'query_string' => [
                    'query' => $q,
                ]
                ],
                'sort' => [
                    $sortCol => [
                        'order' => $sortOrder
                    ]
                    ],
             'aggs' => [
                'facets'=> [
                    'nested' => [
                        'path' => 'string_facet',

                    ],
                    'aggs' => [
                        'names' => [
                            'terms' => [
                                'field' => 'string_facet.facet_name',
                                'size' => 10
                            ],
                            'aggs' => [
                                'values' => [
                                    'terms' => [
                                        'field' => 'string_facet.facet_value',
                                        'size' => 10
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            ]
        ];

        try {
            $response = $this->client->post("/api/index/v1/{$this->index_name}/_search", [
                'json' => $query
            ]);

            $data = json_decode($response->getBody(), true);

                    
            if (empty($data['hits']['total']['value'])) {
                return null;
            }


            $data["hits"]["hits"] = $this->convertSearchEngineArrayToProduct($data["hits"]["hits"]);

            return  ["data"=>$data["hits"]["hits"],
                     "aggregations"=>$data["aggregations"]["facets"]['names']['buckets']
                    ];
        } catch (RequestException $e) {
            echo $e->getMessage();
            return null;
        }  
    }

    function convertSearchEngineArrayToProduct($searchengineResults){
        $newarray = [];
        foreach($searchengineResults as $hit){
            $prod = new Product();
            $prod->pimId = $hit["_source"]["webid"];
            $prod->title = $hit["_source"]["title"];
            $prod->description = $hit["_source"]["description"];
            $prod->price = $hit["_source"]["price"];
            $prod->stockLevel = $hit["_source"]["stockLevel"];
            $prod->categoryName = $hit["_source"]["categoryName"];

            array_push($newarray, $prod);
        }
        return $newarray;

    }
}