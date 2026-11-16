<?php

it('renders all tentang page sections including career path, recruitment slider, departments marquee, and company activities', function () {
    $response = $this->get(route('guest.tentang'));

    $response->assertOk()
        ->assertSee('INTIP KESERUAN INSAN SINAR SOSRO GUNUNG SLAMAT')
        ->assertSee('Berlandaskan ambisi sebagai The Good Beverage Company, Sinar Sosro Gunung Slamat membuka peluang untuk tumbuh dan berkembang bersama para ahlinya.')
        ->assertSee('JENJANG')
        ->assertSee('KARIER')
        ->assertSeeInOrder(['Entry Level', 'Associate', 'Mid Level', 'Senior'])
        ->assertSee('assets/images/kaki-jenjang-karier.png')
        ->assertSee('PROSES')
        ->assertSee('REKRUTMEN')
        ->assertSee('PRO-HIRE')
        ->assertSee('MANAGEMENT')
        ->assertSee('TRAINEE')
        ->assertSeeInOrder(['Seleksi CV', 'Psikotes', 'Interview', 'MCU', 'On-Boarding'])
        ->assertSee('Form Biodata')
        ->assertSee('Study Case')
        ->assertSee('autoAdvanceDelayMs = 10000', false)
        ->assertSee('DEPARTEMEN PERUSAHAAN')
        ->assertSee('HUMAN CAPITAL')
        ->assertSee('SUPPLY CHAIN MANAGEMENT')
        ->assertSee('BUSINESS DEVELOPMENT')
        ->assertSee('SALES & DISTRIBUTION')
        ->assertSee('KEGIATAN PERUSAHAAN')
        ->assertSee('const isTransparentNav = true', false)
        ->assertSee(route('guest.tentang'));
});
