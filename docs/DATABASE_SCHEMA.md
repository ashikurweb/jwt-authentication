# 🎓 Advanced LMS Database Architecture

## Overview

This is a comprehensive, production-ready database schema for an advanced Learning Management System (LMS). The architecture supports all major features found in platforms like Udemy, Coursera, and Teachable.

---

## 📊 Database Tables Summary

| Module | Tables | Description |
|--------|--------|-------------|
| **Core** | 2 | Categories, Tags |
| **Instructors** | 1 | Instructor Profiles |
| **Courses** | 4 | Courses, Sections, Lessons, Resources |
| **Enrollments** | 2 | Enrollments, Lesson Progress |
| **Assessments** | 7 | Quizzes, Questions, Options, Attempts, Answers, Assignments, Submissions |
| **Certificates** | 2 | Templates, Issued Certificates |
| **Reviews** | 3 | Reviews, Votes, Reports |
| **Discussions** | 4 | Discussions, Replies, Upvotes, Followers |
| **E-Commerce** | 7 | Cart, Coupons, Orders, Items, Refunds, Coupon Usage |
| **Subscriptions** | 3 | Plans, Subscriptions, Invoices |
| **Bundles** | 5 | Bundles, Learning Paths, Steps, Enrollments |
| **User Experience** | 3 | Wishlist, Bookmarks, Notes |
| **Notifications** | 4 | Notifications, Preferences, Announcements, Reads |
| **Affiliate** | 3 | Affiliates, Referrals, Payouts |
| **Live Classes** | 2 | Live Classes, Registrations |
| **Messaging** | 3 | Conversations, Participants, Messages |
| **Payouts** | 4 | Instructor Payouts, Earnings, Methods, Withdrawals |
| **Platform** | 7 | Settings, Pages, FAQs, Media, Activity Logs, Course Views, Support |
| **User Extended** | 6 | Profiles, Recommendations, Search History, Watch History, Prerequisites, Related |

**Total: 70+ Tables**

---

## 🗂️ Detailed Schema

### 1. Categories & Tags

```
categories
├── id (PK)
├── parent_id (FK → categories) - Hierarchical structure
├── name, slug, description
├── icon, image, color
├── is_featured, is_active
├── order, meta
└── timestamps, soft_deletes

tags
├── id (PK)
├── name, slug, description
├── is_active
└── timestamps
```

### 2. Instructor Profiles

```
instructor_profiles
├── id (PK)
├── user_id (FK → users)
├── headline, bio, short_bio
├── expertise, social_links
├── rating, total_reviews
├── total_students, total_courses
├── commission_rate (default: 70%)
├── total_earnings, pending_earnings
├── status (pending/approved/rejected/suspended)
├── certifications, achievements (JSON)
└── timestamps, soft_deletes
```

### 3. Courses

```
courses
├── id (PK), uuid
├── instructor_id (FK → users)
├── category_id, subcategory_id (FK → categories)
│
├── BASIC INFO
│   ├── title, slug, subtitle
│   ├── descriptions (short & full)
│   ├── requirements, what_you_learn, target_audience (JSON)
│
├── MEDIA
│   ├── thumbnail, cover_image
│   ├── promo_video, promo_video_type
│
├── PRICING
│   ├── price_type (free/paid/subscription)
│   ├── price, compare_price, currency
│
├── DETAILS
│   ├── level (beginner/intermediate/advanced/all)
│   ├── language, captions (JSON)
│   ├── duration_minutes, total_lectures/sections/resources
│
├── SETTINGS
│   ├── is_published, is_approved, is_featured
│   ├── is_bestseller, is_trending, is_new
│   ├── drip_content, has_certificate
│   ├── allow_qa, allow_reviews, allow_discussions
│
├── ACCESS
│   ├── access_type (lifetime/limited/subscription)
│   └── access_days
│
├── STATISTICS
│   ├── rating, total_reviews
│   ├── total_enrollments, total_views, total_wishlist
│
├── SEO
│   ├── meta_title, meta_description, meta_keywords
│
├── STATUS
│   ├── status (draft/pending_review/published/unpublished/rejected)
│   ├── rejection_reason
│   └── submitted_at, approved_at, published_at
│
└── timestamps, soft_deletes

course_tag (Pivot)
├── course_id (FK)
└── tag_id (FK)

course_instructors (Co-instructors)
├── course_id (FK)
├── instructor_id (FK)
├── revenue_share (percentage)
└── role (primary/co_instructor/assistant)
```

### 4. Course Curriculum

```
course_sections
├── id (PK)
├── course_id (FK)
├── title, description
├── order, is_published
├── duration_minutes
├── DRIP SETTINGS
│   ├── drip_enabled, drip_type
│   └── drip_days, drip_date, drip_after_section_id
└── timestamps, soft_deletes

lessons
├── id (PK), uuid
├── course_id, section_id (FK)
├── title, description, content
├── order
│
├── TYPE (video/text/audio/document/quiz/assignment/live_class/embed/scorm)
│
├── VIDEO SETTINGS
│   ├── video_url, video_provider, video_id
│   ├── duration_seconds, video_thumbnail
│   └── video_qualities (JSON)
│
├── OTHER MEDIA
│   ├── audio_url, audio_duration
│   ├── document_url, document_type
│   └── embed_code
│
├── SETTINGS
│   ├── is_free (preview), is_published
│   ├── is_downloadable, is_prerequisite, is_locked
│
├── DRIP SETTINGS
│   ├── drip_enabled, drip_type
│   └── drip_days, drip_date, drip_after_lesson_id
│
├── STATISTICS
│   └── total_views, total_completions
│
└── timestamps, soft_deletes

lesson_resources
├── id (PK)
├── lesson_id (FK)
├── title, description
├── file_path, file_name, file_type, file_size
├── is_downloadable, order
└── download_count

video_tracks (Subtitles)
├── id (PK)
├── lesson_id (FK)
├── language, label
├── file_path, kind, is_default
└── timestamps
```

### 5. Enrollments & Progress

```
enrollments
├── id (PK), uuid
├── user_id, course_id (FK)
├── order_id (FK, nullable)
│
├── ENROLLMENT INFO
│   ├── enrollment_type (paid/free/gifted/coupon/admin/bundle/subscription)
│   └── price_paid, currency
│
├── ACCESS
│   ├── enrolled_at, expires_at
│   └── is_active
│
├── PROGRESS
│   ├── progress_percentage
│   ├── completed_lessons, total_lessons
│   ├── last_accessed_at, last_lesson_id
│   ├── completed_at
│   └── total_watch_time (seconds)
│
├── STATUS (active/completed/expired/refunded/suspended)
└── timestamps, soft_deletes

lesson_progress
├── id (PK)
├── user_id, lesson_id, enrollment_id (FK)
├── is_completed, completed_at
├── watch_time, last_position
├── progress_percentage, views_count
├── last_watched_at
└── notes (JSON)
```

### 6. Quizzes & Assessments

```
quizzes
├── id (PK), uuid
├── course_id, lesson_id (FK)
├── title, description, instructions
│
├── SETTINGS
│   ├── time_limit (minutes)
│   ├── passing_score (percentage)
│   ├── max_attempts (0 = unlimited)
│   ├── show_answers_after_submission
│   ├── show_correct_answers
│   ├── randomize_questions
│   ├── randomize_options
│   ├── questions_per_page
│   ├── allow_review
│   └── is_required
│
├── total_points, total_questions
└── is_published, order

quiz_questions
├── id (PK)
├── quiz_id (FK)
├── type (single_choice/multiple_choice/true_false/short_answer/
│         long_answer/fill_blank/matching/ordering/image_choice/essay)
├── question, explanation
├── image, audio, video
├── points, order
├── is_required
└── settings (JSON - case sensitivity, etc.)

quiz_options
├── id (PK)
├── question_id (FK)
├── option_text, image
├── is_correct, feedback
├── order, match_with
└── timestamps

quiz_attempts
├── id (PK), uuid
├── user_id, quiz_id, enrollment_id (FK)
├── attempt_number
├── started_at, submitted_at, time_spent
│
├── SCORING
│   ├── total/answered/correct/wrong/skipped questions
│   ├── score_earned, score_total, percentage
│   └── is_passed
│
├── status (in_progress/submitted/graded/expired)
├── feedback, graded_by, graded_at
└── timestamps

quiz_answers
├── id (PK)
├── attempt_id, question_id (FK)
├── selected_options (JSON)
├── text_answer, order_answer, matching_answer
├── is_correct, points_earned
├── feedback, is_flagged
└── timestamps
```

### 7. Assignments

```
assignments
├── id (PK), uuid
├── course_id, lesson_id (FK)
├── title, description, instructions
│
├── SETTINGS
│   ├── total_points, passing_points
│   ├── due_date
│   ├── allow_late_submission
│   ├── late_submission_penalty
│   ├── max_file_size (MB)
│   ├── allowed_file_types (JSON)
│   └── max_submissions
│
├── is_required, is_published, order
├── attachments (JSON)
└── timestamps, soft_deletes

assignment_submissions
├── id (PK), uuid
├── assignment_id, user_id, enrollment_id (FK)
├── submission_number
├── content (text), files (JSON)
│
├── GRADING
│   ├── status (draft/submitted/grading/graded/returned/resubmit)
│   ├── points_earned
│   ├── is_late, late_penalty_applied
│   ├── feedback, inline_comments (JSON)
│   ├── graded_by, graded_at
│
└── submitted_at, timestamps, soft_deletes
```

### 8. Certificates

```
certificate_templates
├── id (PK)
├── name, description
├── orientation (landscape/portrait)
├── size (A4/Letter)
├── background_image, background_color
├── html_content, styles, elements (JSON)
├── is_default, is_active
└── timestamps, soft_deletes

certificates
├── id (PK), uuid
├── certificate_number (unique)
├── user_id, course_id, enrollment_id, template_id (FK)
│
├── DETAILS
│   ├── student_name, course_title, instructor_name
│   ├── completion_date, issue_date, expiry_date
│
├── VERIFICATION
│   ├── verification_url, qr_code
│
├── FILES
│   ├── pdf_path, image_path
│
├── course_duration_hours, final_score, grade
├── is_valid, notes
└── timestamps, soft_deletes
```

### 9. Reviews & Ratings

```
reviews
├── id (PK)
├── user_id, course_id, enrollment_id (FK)
│
├── RATING
│   ├── rating (1.0-5.0)
│   ├── title, content
│   ├── rating_content, rating_instructor, rating_value
│
├── MODERATION
│   ├── status (pending/approved/rejected/flagged)
│   ├── rejection_reason
│   └── moderated_by, moderated_at
│
├── ENGAGEMENT
│   ├── helpful_count, not_helpful_count, report_count
│
├── INSTRUCTOR RESPONSE
│   ├── instructor_response, responded_at
│
├── is_featured, is_verified_purchase
└── timestamps, soft_deletes

review_votes
├── review_id, user_id (FK)
├── vote (helpful/not_helpful)
└── timestamps

review_reports
├── review_id, user_id (FK)
├── reason, description
└── status (pending/reviewed/dismissed)
```

### 10. Discussions & Q&A

```
discussions
├── id (PK), uuid
├── user_id, course_id, lesson_id (FK)
├── title, content
├── type (question/discussion/announcement)
├── status (open/answered/closed/flagged)
├── is_pinned, is_featured
├── best_answer_id (FK → discussion_replies)
│
├── ENGAGEMENT
│   ├── views_count, replies_count
│   ├── upvotes_count, followers_count
│
├── last_activity_at
└── timestamps, soft_deletes

discussion_replies
├── id (PK)
├── discussion_id, user_id, parent_id (FK)
├── content
├── is_best_answer, is_instructor_reply
├── upvotes_count, replies_count
├── status (active/flagged/deleted)
└── timestamps, soft_deletes

discussion_upvotes (Polymorphic)
├── user_id (FK)
├── upvoteable_type, upvoteable_id
└── timestamps

discussion_followers
├── discussion_id, user_id (FK)
└── timestamps
```

### 11. E-Commerce

```
carts
├── id (PK)
├── user_id (FK, nullable)
├── session_id (for guests)
└── timestamps

cart_items
├── cart_id, course_id (FK)
├── price
└── timestamps

coupons
├── id (PK)
├── code (unique), name, description
│
├── DISCOUNT
│   ├── type (percentage/fixed/free)
│   ├── discount_value, max_discount
│   └── min_order_value
│
├── LIMITS
│   ├── usage_limit, per_user_limit, used_count
│
├── VALIDITY
│   ├── starts_at, expires_at
│
├── RESTRICTIONS
│   ├── is_active
│   ├── applicable_courses, applicable_categories (JSON)
│   ├── excluded_courses (JSON)
│   └── first_purchase_only
│
└── created_by, timestamps, soft_deletes

orders
├── id (PK), uuid, order_number
├── user_id (FK)
│
├── PRICING
│   ├── subtotal, discount_amount, tax_amount, total
│   └── currency
│
├── COUPON
│   ├── coupon_id (FK), coupon_code
│
├── STATUS (pending/processing/completed/failed/cancelled/refunded)
│
├── PAYMENT
│   ├── payment_status (pending/paid/failed/refunded)
│   ├── payment_method, payment_gateway
│   ├── transaction_id, payment_details (JSON)
│   └── paid_at
│
├── BILLING INFO
│   └── name, email, phone, address, city, state, country, zip
│
├── INVOICE
│   └── invoice_number, invoice_path
│
└── notes, timestamps, soft_deletes

order_items
├── order_id, course_id, instructor_id (FK)
├── course_title
├── price, discount, final_price
├── bundle_id (nullable)
├── instructor_share, platform_share
└── timestamps

refunds
├── id (PK), uuid
├── order_id, user_id (FK)
├── amount, currency
├── reason
├── status (pending/approved/rejected/processed)
├── transaction_id, admin_notes
├── processed_by, processed_at
└── timestamps

coupon_usages
├── coupon_id, user_id, order_id (FK)
├── discount_amount
└── timestamps
```

### 12. Subscriptions

```
subscription_plans
├── id (PK)
├── name, slug, description
├── badge_text, badge_color
│
├── PRICING
│   ├── price, currency
│   ├── billing_period (monthly/quarterly/yearly/lifetime)
│   └── billing_interval
│
├── TRIAL
│   ├── has_trial, trial_days
│
├── FEATURES
│   ├── features (JSON)
│   ├── access_all_courses
│   ├── included_categories, excluded_courses (JSON)
│   ├── max_courses
│   ├── download_resources, certificates, priority_support
│
├── is_popular, is_active, order
├── stripe_product_id, stripe_price_id, paypal_plan_id
└── timestamps, soft_deletes

subscriptions
├── id (PK), uuid
├── user_id, plan_id (FK)
├── subscription_id (external)
│
├── STATUS (active/trialing/past_due/paused/cancelled/expired)
│
├── BILLING
│   ├── price, currency, payment_method
│
├── DATES
│   ├── starts_at, trial_ends_at
│   ├── current_period_start, current_period_end
│   ├── cancelled_at, ends_at
│
├── CANCELLATION
│   ├── cancellation_reason
│   └── cancel_at_period_end
│
├── stripe_subscription_id, paypal_subscription_id
└── timestamps, soft_deletes

subscription_invoices
├── invoice_number (unique)
├── subscription_id, user_id (FK)
├── amount, tax, total, currency
├── status (draft/open/paid/void/uncollectible)
├── billing_period_start, billing_period_end
├── due_date, paid_at
├── payment_method, transaction_id, pdf_path
└── timestamps
```

### 13. Bundles & Learning Paths

```
bundles
├── id (PK), uuid
├── instructor_id (FK)
├── title, slug
├── short_description, description
├── thumbnail, cover_image
├── price, compare_price, currency
├── is_published, is_featured
├── total_courses, total_duration_hours
├── total_enrollments, rating
├── meta_title, meta_description
└── timestamps, soft_deletes

bundle_courses
├── bundle_id, course_id (FK)
├── order
└── timestamps

learning_paths
├── id (PK), uuid
├── created_by (FK)
├── title, slug
├── short_description, description
├── thumbnail, cover_image
├── difficulty, estimated_hours
├── skill_outcome
├── is_free, price, currency
├── is_published, is_featured, is_sequential
├── total_enrollments, completion_rate
└── timestamps, soft_deletes

learning_path_steps
├── learning_path_id, course_id (FK)
├── title, description
├── order
├── type (course/milestone/quiz/project)
├── is_required, is_locked
├── completion_requirements (JSON)
└── timestamps

learning_path_enrollments
├── user_id, learning_path_id (FK)
├── progress_percentage, completed_steps
├── current_step_id (FK)
├── enrolled_at, completed_at
└── status (active/completed/paused)
```

### 14. Wishlist, Bookmarks & Notes

```
wishlists
├── user_id, course_id (FK)
├── price_alert (notify on price drop)
└── timestamps

bookmarks
├── user_id, lesson_id, course_id (FK)
├── title, note
├── timestamp (video position)
└── timestamps

student_notes
├── id (PK), uuid
├── user_id, lesson_id, course_id (FK)
├── content
├── timestamp (video position)
├── color
└── timestamps, soft_deletes
```

### 15. Notifications & Announcements

```
notifications
├── uuid (PK)
├── user_id (FK)
├── type, title, message
├── icon, icon_color
├── action_url, action_text
├── notifiable_type, notifiable_id (Polymorphic)
├── data (JSON)
├── read_at, sent_at
└── timestamps

notification_preferences
├── user_id (FK)
│
├── EMAIL
│   ├── course_updates, new_lessons, announcements
│   ├── promotions, qa_replies, review_replies
│   └── assignment_feedback, certificate_issued
│
├── PUSH
│   ├── course_updates, new_lessons, announcements
│   ├── promotions, qa_replies
│
├── INSTRUCTOR
│   ├── new_enrollments, new_reviews
│   └── new_questions, payout_updates
│
└── timestamps

announcements
├── id (PK), uuid
├── user_id (author), course_id (FK)
├── title, content
├── type (info/warning/success/danger)
├── audience (all/enrolled/specific)
├── is_pinned, send_email, send_push
├── published_at, expires_at
├── views_count
└── timestamps, soft_deletes

announcement_reads
├── announcement_id, user_id (FK)
└── timestamps
```

### 16. Affiliate System

```
affiliates
├── id (PK), uuid
├── user_id (FK)
├── affiliate_code (unique), referral_link
│
├── COMMISSION
│   ├── commission_rate (default 20%)
│   └── cookie_days (default 30)
│
├── STATISTICS
│   ├── total_clicks, total_referrals, total_conversions
│   └── total_earnings, pending_earnings, paid_earnings
│
├── STATUS (pending/approved/suspended/rejected)
├── approved_at
│
├── PAYMENT
│   ├── payment_method, payment_details (JSON)
│   └── minimum_payout
│
└── timestamps, soft_deletes

affiliate_referrals
├── affiliate_id, referred_user_id, order_id (FK)
├── ip_address, user_agent, landing_page
├── status (clicked/registered/converted/expired)
├── order_amount, commission_amount, commission_rate
├── clicked_at, registered_at, converted_at, expires_at
└── timestamps

affiliate_payouts
├── id (PK), uuid
├── affiliate_id (FK)
├── amount, currency
├── payment_method, payment_details, transaction_id
├── status (pending/processing/completed/failed/cancelled)
├── notes, processed_by, processed_at
└── timestamps
```

### 17. Live Classes & Messaging

```
live_classes
├── id (PK), uuid
├── course_id, lesson_id, instructor_id (FK)
├── title, description, thumbnail
│
├── SCHEDULE
│   ├── scheduled_at, duration_minutes, timezone
│
├── MEETING
│   ├── platform (zoom/google_meet/youtube_live/vimeo/custom)
│   ├── meeting_id, meeting_password
│   ├── meeting_url, host_url, recording_url
│
├── SETTINGS
│   ├── is_free, price
│   ├── max_attendees
│   ├── enable_chat, enable_qa
│   └── enable_recording, enable_replay
│
├── STATUS (scheduled/live/ended/cancelled)
├── started_at, ended_at
│
├── STATISTICS
│   └── registered_count, attended_count, peak_viewers
│
└── timestamps, soft_deletes

live_class_registrations
├── live_class_id, user_id (FK)
├── attended
├── joined_at, left_at, watch_time
├── reminder_sent
└── timestamps

conversations
├── id (PK), uuid
├── course_id (FK, nullable)
├── subject
├── type (direct/support/course_inquiry)
├── last_message_at, is_closed
└── timestamps, soft_deletes

conversation_participants
├── conversation_id, user_id (FK)
├── last_read_at, unread_count, is_muted
└── timestamps

messages
├── id (PK), uuid
├── conversation_id, sender_id (FK)
├── content, attachments (JSON)
├── read_at, is_system_message
└── timestamps, soft_deletes
```

### 18. Instructor Payouts

```
instructor_payouts
├── id (PK), uuid
├── instructor_id (FK)
├── amount, currency
│
├── PERIOD
│   ├── period_start, period_end
│
├── BREAKDOWN
│   ├── total_orders
│   ├── gross_amount, platform_fee, tax_withheld
│   └── net_amount
│
├── PAYMENT
│   ├── payment_method, payment_details (JSON)
│   └── transaction_id
│
├── STATUS (pending/processing/completed/failed/cancelled)
├── notes, processed_by, processed_at
└── timestamps

instructor_earnings
├── instructor_id, course_id, order_id, order_item_id (FK)
├── order_amount
├── commission_rate, instructor_amount, platform_amount
├── payout_id (FK, nullable)
├── status (pending/cleared/paid/refunded)
└── timestamps

payout_methods
├── id (PK)
├── user_id (FK)
├── type (paypal/bank_transfer/stripe/wise/payoneer)
├── name
│
├── PAYPAL
│   └── paypal_email
│
├── BANK
│   ├── bank_name, bank_account_name
│   ├── bank_account_number, bank_routing_number
│   ├── bank_swift_code, bank_iban
│   └── bank_country
│
├── details (JSON)
├── is_default, is_verified
└── timestamps
```

### 19. Platform Tables

```
settings
├── id (PK)
├── group (general/email/payment/seo)
├── key (unique), value
├── type (string/integer/boolean/json/file)
├── description, is_public
└── timestamps

pages (CMS)
├── id (PK)
├── title, slug (unique)
├── content, template
├── is_published, show_in_navigation, show_in_footer
├── meta_title, meta_description
├── order, created_by, updated_by
└── timestamps, soft_deletes

faqs
├── id (PK)
├── course_id (FK, nullable)
├── category, question, answer
├── is_published, order, helpful_count
└── timestamps, soft_deletes

media
├── id (PK), uuid
├── user_id (FK)
├── name, file_name, file_path
├── disk, mime_type, size
├── type (image/video/audio/document/other)
├── width, height, duration
├── conversions (JSON)
├── alt_text, caption
└── timestamps, soft_deletes

activity_logs
├── id (PK)
├── user_id (FK)
├── log_name, event, description
├── subject_type, subject_id (Polymorphic)
├── causer_type, causer_id (Polymorphic)
├── properties (JSON)
├── ip_address, user_agent
└── timestamps

course_views
├── course_id, user_id (FK)
├── ip_address, user_agent
├── referrer, country, device_type
├── viewed_date
└── timestamps

support_tickets
├── id (PK), uuid, ticket_number
├── user_id, course_id, order_id (FK)
├── subject, message, attachments (JSON)
├── category, priority, status
├── assigned_to (FK)
├── first_response_at, resolved_at, closed_at
├── satisfaction_rating, satisfaction_feedback
└── timestamps, soft_deletes

support_ticket_replies
├── ticket_id, user_id (FK)
├── message, attachments (JSON)
├── is_internal_note
└── timestamps, soft_deletes
```

### 20. User Extended Tables

```
user_profiles
├── id (PK)
├── user_id (FK)
│
├── PERSONAL
│   ├── first_name, last_name
│   ├── avatar, cover_image
│   ├── date_of_birth, gender
│
├── BIO
│   ├── headline, bio
│
├── LOCATION
│   ├── country, city, timezone, language
│
├── SOCIAL LINKS
│   └── website, twitter, linkedin, facebook, etc.
│
├── PROFESSIONAL
│   ├── occupation, company
│   ├── skills, interests (JSON)
│
├── learning_goals (JSON)
├── profile_completed
└── timestamps

course_recommendations
├── user_id, course_id (FK)
├── score, reason
├── type (personalized/trending/popular/similar/instructor)
├── is_dismissed
└── timestamps

search_history
├── user_id (FK), session_id
├── query, results_count
├── filters (JSON)
└── timestamps

watch_history
├── user_id, lesson_id, course_id (FK)
├── last_position, duration_watched
├── progress_percentage
├── last_watched_at
└── timestamps

course_prerequisites
├── course_id, prerequisite_course_id (FK)
├── is_required, order
└── timestamps

related_courses
├── course_id, related_course_id (FK)
├── relationship (similar/next_level/complementary)
├── order
└── timestamps

withdrawal_requests
├── id (PK), uuid
├── user_id, payout_method_id (FK)
├── amount, currency
├── status, notes, admin_notes
├── transaction_id
├── processed_by, processed_at
└── timestamps
```

---

## 🔗 Entity Relationship Overview

```
Users (1) ─────────────── (1) instructor_profiles
  │                              │
  │ (1..*)                       │ (1..*)
  ├── enrollments                └── courses
  │      │                            │
  │      └── lesson_progress          ├── course_sections
  │                                   │      └── lessons
  │                                   ├── quizzes
  │                                   ├── assignments
  │                                   └── discussions
  │
  ├── orders ─────────── order_items
  │      │
  │      └── refunds
  │
  ├── subscriptions
  │
  ├── affiliates ────── affiliate_referrals
  │
  └── support_tickets
```

---

## 🚀 Migration Order

1. `create_categories_table` - Categories & Tags
2. `create_instructor_profiles_table` - Instructor Profiles
3. `create_courses_table` - Courses, Tags Pivot, Co-instructors
4. `create_course_curriculum_tables` - Sections, Lessons, Resources, Video Tracks
5. `create_enrollments_table` - Enrollments, Lesson Progress
6. `create_quizzes_tables` - Quizzes, Questions, Options, Attempts, Answers
7. `create_assignments_table` - Assignments, Submissions
8. `create_certificates_table` - Templates, Certificates
9. `create_reviews_table` - Reviews, Votes, Reports
10. `create_discussions_table` - Discussions, Replies, Upvotes, Followers
11. `create_orders_table` - Carts, Coupons, Orders, Items, Refunds
12. `create_subscriptions_table` - Plans, Subscriptions, Invoices
13. `create_bundles_and_learning_paths_table` - Bundles, Learning Paths
14. `create_wishlists_and_bookmarks_table` - Wishlists, Bookmarks, Notes
15. `create_notifications_table` - Notifications, Preferences, Announcements
16. `create_affiliates_table` - Affiliates, Referrals, Payouts
17. `create_live_classes_and_messages_table` - Live Classes, Messaging
18. `create_instructor_payouts_table` - Payouts, Earnings, Methods
19. `create_platform_tables` - Settings, Pages, FAQs, Media, Logs, Support
20. `create_user_related_tables` - Profiles, Recommendations, History
21. `add_deferred_foreign_keys` - Deferred Foreign Keys

---

## 📝 Notes

### Indexes
All tables have appropriate indexes for:
- Primary keys
- Foreign keys
- Frequently queried columns
- Composite indexes for common query patterns

### Soft Deletes
Most tables support soft deletes to maintain data integrity and allow recovery.

### JSON Columns
Used for flexible data storage:
- Course requirements, learning outcomes
- Quiz settings, answers
- Payment details
- Notification data

### UUIDs
Critical public-facing entities have UUIDs for:
- Security (hiding sequential IDs)
- External integrations

### Timestamps
All tables include `created_at` and `updated_at` for audit trails.

---

## 🛠️ Run Migrations

```bash
php artisan migrate
```

To rollback:
```bash
php artisan migrate:rollback
```

To fresh install:
```bash
php artisan migrate:fresh
```

---

Created for Advanced API-based LMS Project
Built with Laravel & JWT Authentication
