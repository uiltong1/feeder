<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
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
     * @var User
     */
    private User $user;

    /**
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user  = User::factory()->create();
        $this->baseUrl = 'api/users';
    }

    /**
     * @test
     */
    public function listAllUsers()
    {
        $this->get($this->baseUrl)
            ->assertJsonStructure([[
                'id',
                'name',
                'email'
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
    public function getUserById(int $id, int $expectedStatus, array $responseStructure)
    {
        if ($expectedStatus == 200) {
            $id = $this->user->id;
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
    public function storeUser(array $payload, array $responseStructure, int $expectedStatus)
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
    public function updateUser(array $payload, array $responseStructure, int $expectedStatus)
    {
        $id = $this->user->id;

        if ($expectedStatus == 406) {
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
    public function deleteUser(int $id, int $expectedStatus)
    {
        if ($expectedStatus == 204) {
            $id = $this->user->id;
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
                    'name',
                    'email'
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
                    "name" => "",
                    "email" => "",
                ],
                'responseStructure' => ["name", "email"],
                'expectedStatus'    => 406
            ],
            [
                'payload' => [
                    "name"  => "Testing",
                    "email" => "testing@mail.com",
                ],
                'responseStructure' => [
                    "name",
                    "email"
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
                    "name" => "",
                    "email" => "",
                ],
                'responseStructure' => ["name", "email"],
                'expectedStatus'    => 406
            ],
            [
                'payload' => [
                    "name"  => "Testing",
                    "email" => "testing2@mail.com",
                ],
                'responseStructure' => [
                    "name",
                    "email"
                ],
                'expectedStatus'    => 200
            ]
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
