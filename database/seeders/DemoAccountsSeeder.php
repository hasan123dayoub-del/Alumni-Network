<?php

namespace Database\Seeders;

use App\Models\AlumniProfile;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\Major;
use App\Models\Notification;
use App\Models\StudentProfile;
use App\Models\University;
use App\Models\UniversityAdmin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Fixed, ready-to-use accounts for the public demo (password "password" for all),
 * plus upcoming events and notifications so the events and notifications modules
 * can be tried right away.
 */
class DemoAccountsSeeder extends Seeder
{
    public function run(): void
    {
        // The demo university is always id 1, so the docs can use /universities/1/... in every example.
        $university = University::findOrFail(1);
        $university->forceFill([
            'name' => 'Northbridge University',
            'country' => 'Syria',
            'website' => 'https://northbridge.edu',
        ])->save();
        Event::where('university_id', $university->id)->delete();
        $faculty = Faculty::create(['name' => 'Faculty of Informatics Engineering', 'university_id' => $university->id]);
        $major = Major::create(['name' => 'Software Engineering', 'faculty_id' => $faculty->id]);

        $admin = $this->user('Super Admin', 'admin@alumni.demo', 'super_admin');

        $uniAdmin = $this->user('Rana Khoury', 'uniadmin@alumni.demo', 'uni_admin');
        UniversityAdmin::create(['user_id' => $uniAdmin->id, 'university_id' => $university->id]);

        $alumni = $this->user('Karim Nassar', 'alumni@alumni.demo', 'alumni');
        AlumniProfile::factory()->create([
            'user_id' => $alumni->id,
            'major_id' => $major->id,
            'graduation_year' => 2022,
            'current_job_title' => 'Backend Developer',
            'current_company' => 'CloudNine Labs',
            'bio' => 'Laravel developer who enjoys mentoring final-year students.',
            'city' => 'Latakia',
            'country' => 'Syria',
            'status' => 'active',
            'is_open_to_mentor' => true,
        ]);

        $student = $this->user('Lina Saleh', 'student@alumni.demo', 'student');
        StudentProfile::factory()->create([
            'user_id' => $student->id,
            'major_id' => $major->id,
            'enrollment_year' => 2023,
            'expected_graduation_year' => 2027,
            'status' => 'active',
        ]);

        // [title, type, location or link, start, end, capacity, status, description]
        // The hackathon is running right now, so a university admin can record attendance in the demo
        // (attendance is only accepted during the event). The data is reseeded on every restart.
        $events = [
            ['Career Fair 2026', 'campus', 'Main Hall, Northbridge University', now()->addDays(7)->setTime(10, 0), now()->addDays(7)->setTime(16, 0), 200, 'upcoming', 'Meet 30 companies hiring interns and graduates in software, data and design.'],
            ['Tech Talk: Building Reliable APIs', 'online', 'https://meet.example.com/reliable-apis', now()->addDays(12)->setTime(18, 0), now()->addDays(12)->setTime(20, 0), 100, 'upcoming', 'An alumni engineer shares how they design, test and monitor production APIs.'],
            ['Alumni Networking Night', 'hybrid', 'Alumni Club, City Center', now()->addDays(20)->setTime(18, 0), now()->addDays(20)->setTime(21, 0), 80, 'upcoming', 'An evening for alumni and final-year students to connect and talk careers.'],
            ['Northbridge Hackathon Week', 'campus', 'Innovation Lab, Building C', now()->subHours(2), now()->addDays(5), 60, 'ongoing', 'A week-long team hackathon mentored by alumni. Attendance is recorded at the lab.'],
        ];

        $created = [];
        foreach ($events as [$title, $type, $place, $start, $end, $capacity, $status, $description]) {
            $created[] = Event::create([
                'university_id' => $university->id,
                'title' => $title,
                'description' => $description,
                'type' => $type,
                'location' => $type === 'online' ? null : $place,
                'meeting_link' => $type === 'campus' ? null : ($type === 'online' ? $place : 'https://meet.example.com/alumni-night'),
                'start_date' => $start,
                'end_date' => $end,
                'capacity' => $capacity,
                'status' => $status,
            ]);
        }

        // The alumni is already registered for the networking night; the student is left to register from the docs.
        $created[2]->registrations()->create(['user_id' => $alumni->id, 'registered_at' => now()]);

        $notifications = [
            [$alumni, 'account_approval', User::class, $alumni->id, 'Your account registration has been approved successfully.', now()->subDays(3)],
            [$alumni, 'event_reminder', Event::class, $created[2]->id, 'Reminder: Alumni Networking Night starts in 20 days.', null],
            [$student, 'account_approval', User::class, $student->id, 'Your account registration has been approved successfully.', now()->subDay()],
            [$student, 'event_reminder', Event::class, $created[0]->id, 'Career Fair 2026 is next week. Register to save your spot.', null],
            [$student, 'event_reminder', Event::class, $created[1]->id, 'New online event: Tech Talk: Building Reliable APIs.', null],
        ];

        foreach ($notifications as [$user, $type, $relatedType, $relatedId, $message, $readAt]) {
            Notification::create([
                'user_id' => $user->id,
                'type' => $type,
                'related_type' => $relatedType,
                'related_id' => $relatedId,
                'message' => $message,
                'read_at' => $readAt,
            ]);
        }
    }

    private function user(string $name, string $email, string $role): User
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $user->assignRole($role);

        return $user;
    }
}
