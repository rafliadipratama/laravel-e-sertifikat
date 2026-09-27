<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CertificateTest extends TestCase
{
    use RefreshDatabase;

    private Event $event;
    private Certificate $certificate;

    protected function setUp(): void
    {
        parent::setUp();

        $this->event = Event::create([
            'title' => 'Webinar AI Testing',
            'organizer' => 'Komunitas Developer',
            'event_date' => now()->toDateString(),
            'signer_name' => 'John Doe',
            'signer_position' => 'Ketua Pelaksana',
            'certificate_prefix' => 'TEST/CERT',
        ]);

        $this->certificate = $this->event->certificates()->create([
            'recipient_name' => 'Rafli Adi Pratama',
            'recipient_email' => 'rafli@example.com',
            'role' => 'Peserta',
            'certificate_number' => 'TEST/CERT/0001',
            'issue_date' => now()->toDateString(),
            'verification_token' => Str::random(40),
        ]);
    }

    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Sistem E-Sertifikat Digital');
    }

    public function test_events_page_loads_successfully(): void
    {
        $response = $this->get('/events');
        $response->assertStatus(200);
        $response->assertSee('Manajemen Acara');
        $response->assertSee('Webinar AI Testing');
    }

    public function test_verification_index_loads(): void
    {
        $response = $this->get('/verifikasi');
        $response->assertStatus(200);
        $response->assertSee('Verifikasi Keaslian Sertifikat');
    }

    public function test_verification_show_valid_certificate(): void
    {
        $response = $this->get('/verifikasi/' . $this->certificate->verification_token);
        $response->assertStatus(200);
        $response->assertSee($this->certificate->recipient_name);
        $response->assertSee('Terverifikasi Valid');
    }

    public function test_certificate_pdf_preview(): void
    {
        $response = $this->get('/certificates/' . $this->certificate->id . '/pdf');
        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('content-type'));
    }

    public function test_certificate_creation(): void
    {
        $response = $this->post('/events/' . $this->event->id . '/certificates', [
            'recipient_name' => 'Budi Santoso',
            'recipient_email' => 'budi@example.com',
            'role' => 'Narasumber',
            'certificate_number' => 'TEST/CERT/0002',
            'issue_date' => now()->toDateString(),
        ]);

        $response->assertRedirect('/events/' . $this->event->id);
        $this->assertDatabaseHas('certificates', [
            'recipient_name' => 'Budi Santoso',
            'certificate_number' => 'TEST/CERT/0002',
        ]);
    }
}
