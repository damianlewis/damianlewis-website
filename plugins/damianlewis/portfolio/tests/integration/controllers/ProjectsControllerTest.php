<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Tests\Integration\Controllers;

use ApiTestCase;
use DamianLewis\Portfolio\Models\Project;

class ProjectsControllerTest extends ApiTestCase
{
    public function __construct()
    {
        parent::__construct();

        $this->plugins = ['DamianLewis.Portfolio'];

        $this->setApiPrefix('api/v1');
    }

    /** @test */
    public function it_fetches_projects(): void
    {
        factory(Project::class, 10)->create();

        $response = $this->get($this->getApiEndpoint('projects'));

        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
    }

    /** @test */
    public function it_fetches_a_single_project(): void
    {
        $project = factory(Project::class)->create();

        $response = $this->get($this->getApiEndpoint('projects/1'));

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'title' => $project->title,
                'text' => $project->description,
                'tagLine'=> $project->tag_line
            ]
        ]);
    }

    /** @test */
    public function it_returns_an_error_when_a_project_doesnt_exist(): void
    {
        factory(Project::class)->create();

        $response = $this->get($this->getApiEndpoint('projects/2'));

        $response->assertStatus(404);
        $response->assertExactJson([
            'error' => [
                'code' => 404,
                'message' => 'Project not found'
            ]
        ]);
    }
}
