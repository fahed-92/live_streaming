<?php

it('has roomattendance page', function () {
    $response = $this->get('/roomattendance');

    $response->assertStatus(200);
});
