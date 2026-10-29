<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([


            RoleAndPermissionSeeder::class,
            UniversitySeeder::class,
            FacultySeeder::class,
            MajorSeeder::class,
            UserSeeder::class,
            SkillSeeder::class,

            StudentProfileSeeder::class,
            AlumniProfileSeeder::class,
            WorkExperienceSeeder::class,
            SkillSeeder::class,

            ConnectionSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            ReactionSeeder::class,

            JobSeeder::class,
            JobApplicationSeeder::class,

            EventSeeder::class,
            EventRegistrationSeeder::class,

            MentorshipProgramSeeder::class,
            MentorshipRequestSeeder::class,

            ConversationSeeder::class,
            MessageSeeder::class,

            // NotificationSeeder::class,
            AttachmentSeeder::class,

            ReportSnapshotSeeder::class,
            UserRoleSeeder::class,
            GraduationRequestSeeder::class,

            // Fixed accounts and data for the public demo.
            DemoAccountsSeeder::class,
        ]);
    }
}
