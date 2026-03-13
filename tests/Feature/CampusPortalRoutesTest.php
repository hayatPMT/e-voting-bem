<?php

use App\Models\Kampus;

beforeEach(function () {
    // ensure the sqlite in-memory configuration is applied early
    $this->app['config']->set('database.default', 'sqlite');
    $this->app['config']->set('database.connections.sqlite.database', ':memory:');

    // run the migrations fresh for each test
    $this->artisan('migrate:fresh');
});

it('returns 404 when campus slug does not exist', function () {
    $this->get(route('campus.portal', ['kampus_slug' => 'nonexistent']))
        ->assertStatus(404);
});

it('global login page remains accessible even with campus slug routing', function () {
    // '/login' previously matched the {kampus_slug} wildcard and resulted in a
    // 404. Regex constraint has been added to prevent capturing reserved words.
    $this->get('/login')->assertStatus(200);
});

it('can access all defined campus routes for an active campus', function () {
    // include CSRF tokens with POST requests to satisfy middleware
    // (we had tried disabling the middleware but the web group still enforces it).

    $kampus = Kampus::create([
        'nama' => 'Test Campus',
        'kode' => 'TC',
        'slug' => 'tc',
        'is_active' => true,
    ]);

    $routes = [
        ['get', 'campus.portal', []],
        ['post', 'campus.select-mode', ['mode' => 'online']],
        ['get', 'campus.chart', []],
        ['get', 'campus.login', []],
        ['post', 'campus.authenticate', ['email' => 'foo', 'password' => 'bar']],
        ['get', 'campus.verifikasi', []],
        ['post', 'campus.verifikasi.process', ['nim' => '123', 'password' => 'pwd']],
        ['get', 'campus.petugas.login', []],
        ['post', 'campus.petugas.authenticate', ['email' => 'foo', 'password' => 'bar']],
    ];

    foreach ($routes as [$method, $name, $data]) {
        $uri = route($name, ['kampus_slug' => $kampus->slug]);
        if (strtolower($method) === 'post') {
            $data = array_merge($data, ['_token' => csrf_token()]);
        }

        $response = $this->{$method}($uri, $data);

        if ($name === 'campus.chart' && $response->getStatusCode() !== 200) {
            // output content to help debug why chart page returns 404
            dump('chart uri', $uri);
            dump('response code', $response->getStatusCode());
            dump('response body', $response->getContent());
        }

        // most pages should render (200) but some POST handlers redirect (302)
        $this->assertTrue(
            in_array($response->getStatusCode(), [200, 302], true),
            "Failed asserting route $name accessible; returned {$response->getStatusCode()}"
        );
    }
});
