<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     *
     * @var string
     */
    private string $baseUrl;

    /**
     *
     * @var Tag
     */
    private Tag $tag;

    /**
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->tag  = Tag::factory()->create();
        $this->baseUrl = 'api/tags';
    }

    /**
     * @test
     */
    public function listAllTags()
    {
        $this->get($this->baseUrl)
            ->assertJsonStructure([[
                'id',
                'slug',
            ]])
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * @dataProvider requestParamsGet
     * 
     * @param int $id
     * @param int $expectedStatus
     * @param array $responseStructure
     * @test
     */
    public function getTagById(int $id, int $expectedStatus, array $responseStructure)
    {
        if ($expectedStatus == 200) {
            $id = $this->tag->id;
        }

        $this->get($this->baseUrl . "/" . $id)
            ->assertJsonStructure($responseStructure)
            ->assertStatus($expectedStatus);
    }


    /**
     * @dataProvider requestParams
     * 
     * @param array $payload
     * @param array $responseStructure
     * @param int $expectedStatus
     * @test
     */
    public function storeTag(array $payload, array $responseStructure, int $expectedStatus)
    {
        $this->post($this->baseUrl, $payload)
            ->assertJsonStructure($responseStructure)
            ->assertStatus($expectedStatus);
    }


    /**
     * @dataProvider requestParamsUpdate
     * 
     * @param array $payload
     * @param array $responseStructure
     * @param int $expectedStatus
     * @test
     */
    public function updateTag(array $payload, array $responseStructure, int $expectedStatus)
    {
        $id = $this->tag->id;

        if ($expectedStatus == 400) {
            $id = 1000;
        }

        $this->put($this->baseUrl . "/" . $id, $payload)
            ->assertJsonStructure($responseStructure)
            ->assertStatus($expectedStatus);
    }


    /**
     * @dataProvider requestParamsDelete
     * 
     * @param int $id
     * @param int $expectedStatus
     * @test
     */
    public function deleteTag(int $id, int $expectedStatus)
    {
        if ($expectedStatus == 204) {
            $id = $this->tag->id;
        }

        $this->delete($this->baseUrl . "/" . $id)
            ->assertStatus($expectedStatus);
    }

    /**
     * @return array[]
     */
    public function requestParamsGet(): array
    {
        return [
            [
                'id'                => 1000000,
                'expectedStatus'    => 400,
                'responseStructure' => []
            ],
            [
                'id'                => 1000000,
                'expectedStatus'    => 200,
                'responseStructure' => [
                    'id',
                    'slug',
                ]
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function requestParams(): array
    {
        return [
            [
                'payload' => [
                    "slug" => "",
                ],
                'responseStructure' => ["slug"],
                'expectedStatus'    => 406
            ],
            [
                'payload' => [
                    "slug" => "Minha tag",
                ],
                'responseStructure' => [
                    "id",
                    "slug",
                ],
                'expectedStatus'    => 201
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function requestParamsUpdate(): array
    {
        return [
            [
                'payload' => [
                    "slug" => "",
                ],
                'responseStructure' => ["slug"],
                'expectedStatus'    => 406
            ],
            [
                'payload' => [
                    "slug" => "Minha tag",
                ],
                'responseStructure' => [
                    "id",
                    "slug",
                ],
                'expectedStatus'    => 200
            ],
            [
                'payload' => [
                    "slug" => "Minha tag",
                ],
                'responseStructure' => [],
                'expectedStatus'    => 400
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function requestParamsDelete(): array
    {
        return [
            [
                'id'                => 1000000,
                'expectedStatus'    => 400
            ],
            [
                'id'                => 1000000,
                'expectedStatus'    => 204
            ]
        ];
    }
}
