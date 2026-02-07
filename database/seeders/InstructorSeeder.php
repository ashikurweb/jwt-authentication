<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\InstructorProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure instructor role exists
        Role::findOrCreate('instructor', 'api');

        $instructors = [
            [
                'name' => 'Ashikur Rahman',
                'email' => 'ashik@example.com',
                'phone' => '+8801711223344',
                'headline' => 'Senior Full Stack Developer & Lead Instructor',
                'expertise' => 'Laravel, Vue.js, Node.js, AWS',
                'bio' => 'Over 10 years of experience in building scalable web applications. Passionate about teaching modern technology stacks to the next generation of developers.',
                'short_bio' => 'Expert in Full Stack Development with a focus on Vue/Laravel.',
                'commission_rate' => 70,
                'is_featured' => true,
                'status' => 'approved',
                'certifications' => [
                    ['name' => 'AWS Certified Solutions Architect', 'issuer' => 'Amazon Web Services'],
                    ['name' => 'Laravel Certified Developer', 'issuer' => 'Laravel LLC'],
                ],
                'achievements' => [
                    'Built 50+ Enterprise Applications',
                    'Mentored 5000+ Students globally',
                ]
            ],
            [
                'name' => 'Dr. Sarah Connor',
                'email' => 'sarah@example.com',
                'phone' => '+15550102030',
                'headline' => 'Machine Learning Specialist & PhD Researcher',
                'expertise' => 'Python, TensorFlow, PyTorch, Scikit-learn',
                'bio' => 'Specializing in computer vision and natural language processing. I bridge the gap between academic research and practical industry application.',
                'short_bio' => 'PhD in AI with extensive industry experience in ML.',
                'commission_rate' => 80,
                'is_featured' => true,
                'status' => 'approved',
                'certifications' => [
                    ['name' => 'Google Cloud Professional ML Engineer', 'issuer' => 'Google Cloud'],
                ],
                'achievements' => [
                    'Published 10+ Research Papers',
                    'Keynote Speaker at AI Global Summit 2025',
                ]
            ],
            [
                'name' => 'Marcus Aurelius',
                'email' => 'marcus@example.com',
                'phone' => '+39061234567',
                'headline' => 'UI/UX Design Lead & Product Strategist',
                'expertise' => 'Figma, Adobe XD, Design Systems, Typography',
                'bio' => 'Focusing on human-centered design and seamless user experiences. I help brands build products that people love to use.',
                'short_bio' => 'Creative Director with 8+ years in Digital Product Design.',
                'commission_rate' => 75,
                'is_featured' => false,
                'status' => 'approved',
                'certifications' => [
                    ['name' => 'Professional UX Design Certificate', 'issuer' => 'Google'],
                ],
                'achievements' => [
                    'Winner of Red Dot Design Award 2024',
                    'Designed UI for 3 Fortune 500 Companies',
                ]
            ],
            [
                'name' => 'Lila Chen',
                'email' => 'lila@example.com',
                'phone' => '+862112345678',
                'headline' => 'Cybersecurity Analyst & Ethical Hacker',
                'expertise' => 'Penetration Testing, Network Security, Ethical Hacking',
                'bio' => 'Hands-on experience in securing infrastructures and defending against sophisticated cyber threats. My courses focus on defensive and offensive security.',
                'short_bio' => 'Certified Ethical Hacker with a passion for Cybersecurity.',
                'commission_rate' => 70,
                'is_featured' => false,
                'status' => 'approved',
                'certifications' => [
                    ['name' => 'CompTIA Security+', 'issuer' => 'CompTIA'],
                    ['name' => 'CEH (Certified Ethical Hacker)', 'issuer' => 'EC-Council'],
                ],
                'achievements' => [
                    'Secured Financial Network with $1B+ Transactions',
                    'Identified Critical Zero-day Vulnerabilities',
                ]
            ],
            [
                'name' => 'Elena Rodriguez',
                'email' => 'elena@example.com',
                'phone' => '+34911223344',
                'headline' => 'Digital Marketing Consultant & SEO Expert',
                'expertise' => 'Google Ads, Technical SEO, Content Strategy',
                'bio' => 'Expert in scaling businesses through data-driven marketing strategies. I have managed over $10M in ad spend for global clients.',
                'short_bio' => 'SEO Expert who has ranked 100+ keywords on the first page.',
                'commission_rate' => 85,
                'is_featured' => true,
                'status' => 'approved',
                'certifications' => [
                    ['name' => 'Google Search Ads Certification', 'issuer' => 'Google'],
                    ['name' => 'HubSpot Content Marketing', 'issuer' => 'HubSpot'],
                ],
                'achievements' => [
                    'Increased Client Revenue by 400% in 1 Year',
                    'Top 1% Marketer on Upwork',
                ]
            ],
            [
                'name' => 'Kenji Tanaka',
                'email' => 'kenji@example.com',
                'phone' => '+81312345678',
                'headline' => 'Back-end Architect & Go Developer',
                'expertise' => 'Go, Rust, Microservices, Kubernetes',
                'bio' => 'Specialist in building high-performance, concurrent distributed systems. I believe in writing clean, maintainable, and efficient code.',
                'short_bio' => 'Backend expert focused on high-performance Go architectures.',
                'commission_rate' => 70,
                'is_featured' => false,
                'status' => 'pending',
                'certifications' => [
                    ['name' => 'Kubernetes Certified Administrator', 'issuer' => 'CNCF'],
                ],
                'achievements' => [
                    'Contributor to Open Source Go Projects',
                    'Built Real-time Messaging system for 1M+ active users',
                ]
            ],
            [
                'name' => 'Sophie Müller',
                'email' => 'sophie@example.com',
                'phone' => '+49301234567',
                'headline' => 'DevOps Engineer & Cloud Automation Specialist',
                'expertise' => 'Docker, CI/CD, Terraform, Ansible',
                'bio' => 'Bridging the gap between development and operations through automation. I streamline delivery pipelines for fast and reliable releases.',
                'short_bio' => 'DevOps Specialist with a focus on Cloud-Native technologies.',
                'commission_rate' => 75,
                'is_featured' => true,
                'status' => 'approved',
                'certifications' => [
                    ['name' => 'HashiCorp Certified: Terraform Associate', 'issuer' => 'HashiCorp'],
                ],
                'achievements' => [
                    'Reduced Deployment Time by 80% for top e-commerce',
                    'Automated 100% of Infrastructure for a Fintech Startup',
                ]
            ],
        ];

        foreach ($instructors as $data) {
            $user = User::create([
                'uuid' => (string) Str::uuid(),
                'name' => $data['name'],
                'username' => Str::slug($data['name']) . '-' . rand(1000, 9999),
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make('password'), // Global default password
                'status' => 'active',
            ]);

            $user->assignRole('instructor');

            InstructorProfile::create([
                'user_id' => $user->id,
                'headline' => $data['headline'],
                'bio' => $data['bio'],
                'short_bio' => $data['short_bio'],
                'expertise' => $data['expertise'],
                'commission_rate' => $data['commission_rate'],
                'is_featured' => $data['is_featured'],
                'status' => $data['status'],
                'certifications' => $data['certifications'] ?? [],
                'achievements' => $data['achievements'] ?? [],
                'approved_at' => $data['status'] === 'approved' ? now() : null,
            ]);
        }
    }
}
