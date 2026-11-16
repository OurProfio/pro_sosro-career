<?php

it('renders the program page jumbotron and all 3 interactive program sections', function () {
    $response = $this->get(route('guest.program'));

    $response->assertOk()
        ->assertSee('PELUANG MENANTI, MARI BERKEMBANG BERSAMA')
        ->assertSee('Ikuti kegiatan dan program kami di PT Sinar Sosro Gunung Slamat untuk berkembang, memperluas jaringan, dan meraih kesuksesan bersama.')
        ->assertSee('MANAGEMENT TRAINEE')
        ->assertSee('GURU MAGANG')
        ->assertSee('PEMAGANGAN SALES')
        ->assertSee('INTERNSHIP')
        ->assertSee('APA KATA MANAGEMENT TRAINEE KAMI?')
        ->assertSee('APA KATA GURU MAGANG KAMI?')
        ->assertSee('APA KATA PEMAGANGAN SALES KAMI?')
        ->assertSee('APA KATA INTERNSHIP KAMI?')
        ->assertSee('Ahmad Dhani')
        ->assertSee('const isTransparentNav = true', false)
        ->assertSee(route('guest.program'));
});
