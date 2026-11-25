<?php

namespace App\Models;

use Database\Factories\ApplicantFamilyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable('applicant_id', 'relationship', 'relationship_id', 'gender', 'name', 'date_of_birth', 'place_of_birth', 'education', 'edutype_id', 'phone_number', 'work', 'address', 'family_type', 'status')]
class ApplicantFamily extends Model
{
    /** @use HasFactory<ApplicantFamilyFactory> */
    use HasFactory;

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    /**
     * Resolve HRIS thrm_family_connection.RELATIONSHIP_ID from web relationship & gender.
     */
    public static function resolveRelationshipId(?string $relationship, ?string $gender = null): ?int
    {
        $g = strtolower((string) $gender);

        return match (strtolower((string) $relationship)) {
            'father' => 1,
            'mother' => 2,
            'child' => match ($g) {
                'l' => 3,
                'p' => 4,
                default => 3,
            },
            'sibling' => match ($g) {
                'l' => 5,
                'p' => 6,
                default => 42,
            },
            'spouse' => 8,
            'father_in_law' => 11,
            'mother_in_law' => 12,
            default => null,
        };
    }

    /**
     * Resolve HRIS thrm_education.EDUTYPE_ID from stored education label or numeric ID.
     */
    public static function resolveEdutypeId(?string $education): ?int
    {
        $trimmed = trim((string) $education);

        if ($trimmed === '') {
            return null;
        }

        if (ctype_digit($trimmed)) {
            return (int) $trimmed;
        }

        $upper = strtoupper($trimmed);

        return match (true) {
            str_contains($upper, 'S3'), str_contains($upper, 'DOCTOR') => 9,
            str_contains($upper, 'S2'), str_contains($upper, 'MASTER') => 8,
            str_contains($upper, 'S1'), str_contains($upper, 'D4'), str_contains($upper, 'SARJANA'), str_contains($upper, 'BACHELOR') => 7,
            str_contains($upper, 'DIPLOMA'), str_contains($upper, 'D3'), str_contains($upper, 'D2'), str_contains($upper, 'D1') => 5,
            str_contains($upper, 'STM'), str_contains($upper, 'VOCATIONAL') => 10,
            str_contains($upper, 'SMA'), str_contains($upper, 'SMK'), str_contains($upper, 'HIGH SCHOOL') => 4,
            default => 1,
        };
    }
}
