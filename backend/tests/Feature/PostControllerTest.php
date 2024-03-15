<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class PostControllerTest extends TestCase
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
     * @var Post
     */
    private Post $post;

    /**
     *
     * @var User
     */
    private User $user;

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
        $this->post = Post::factory()->create();
        $this->user = User::factory()->create();
        $this->tag  = Tag::factory()->create();
        $this->baseUrl = 'api/posts';
    }

    /**
     * @test
     */
    public function listAllPosts()
    {
        $this->get($this->baseUrl)
            ->assertJsonStructure([[
                'id',
                'title',
                'body',
                'user_id',
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
    public function getPostById(int $id, int $expectedStatus, array $responseStructure)
    {
        if ($expectedStatus == 200) {
            $id = $this->post->id;
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
    public function storePost(array $payload, array $responseStructure, int $expectedStatus)
    {
        if ($expectedStatus == 201) {
            $payload['user_id'] = $this->user->id;
            $payload['tags'] = [$this->tag->id];
        }

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
    public function updatePost(array $payload, array $responseStructure, int $expectedStatus)
    {
        $id = $this->post->id;
        if ($expectedStatus == 200) {
            $payload['user_id'] = $this->user->id;
            $payload['tags'] = [$this->tag->id];
        }

        if ($expectedStatus == 400) {
            $id = 1000;
            $payload['user_id'] = $this->user->id;
            $payload['tags'] = [$this->tag->id];
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
    public function deletePost(int $id, int $expectedStatus)
    {
        if ($expectedStatus == 204) {
            $id = $this->post->id;
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
                    'title',
                    'body',
                    'user_id',
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
                    "title" => "Meu tema",
                    "body" => "Desenvolvimento do meu tema",
                    "user_id" => 2,
                    "tags" => [
                        0,
                        3
                    ]
                ],
                'responseStructure' => ["tags"],
                'expectedStatus'    => 406
            ],
            [
                'payload' => [
                    "title" => "Meu tema",
                    "body" => "Desenvolvimento do meu tema",
                    "user_id" => 2,
                    "tags" => [
                        0,
                        3
                    ]
                ],
                'responseStructure' => [
                    "title",
                    "body",
                    "user_id",
                    "id"
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
                    "title" => "Meu tema",
                    "body" => "Desenvolvimento do meu tema",
                    "user_id" => 2,
                    "tags" => [
                        0,
                        3
                    ]
                ],
                'responseStructure' => ["tags"],
                'expectedStatus'    => 406
            ],
            [
                'payload' => [
                    "title" => "Meu tema",
                    "body" => "Desenvolvimento do meu tema",
                    "user_id" => 2,
                    "tags" => []
                ],
                'responseStructure' => [
                    "id",
                    "title",
                    "body",
                    "user_id",
                ],
                'expectedStatus'    => 200
            ],
            [
                'payload' => [
                    'title' => "Meu titulo",
                    "body" => "Desenvolvimento do meu tema",
                    "user_id" => 2,
                    "tags" => [
                        0,
                        3
                    ]
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
