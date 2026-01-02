<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\Picture;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function index()
    {
        $pictures = Picture::get();

        $posts = Post::limit(3)->where('status','published')->orderBy('id', 'DESC')->get();
        return view('frontend.index', compact('posts', 'pictures'));
    }

    public function posts(Request $request)
    {

        $query = Post::query()->where('status', 'published');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        // Sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'commented':
                $query->withCount('approvedComments')
                    ->orderBy('approved_comments_count', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $posts = $query->with(['category'])
            ->paginate(8)
            ->withQueryString();

        $categories = Category::where('status', 1)->get();
        $popularPosts = Post::where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return view('frontend.posts', compact('posts', 'categories', 'popularPosts'));
    }

    public function post($slug)
    {
        $post = Post::where('slug', $slug)->first();
        $categories = Category::where('status', 1)->get();
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            //->where('status', 'published')
            ->inRandomOrder()
            ->limit(3)
            ->get();
        return view('frontend.post', compact('post', 'categories', 'relatedPosts'));
    }

    public function storeComment(Request $request, Post $post)
    {

        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->name = $request->input('name');
        $comment->comment = $request->input('comment');
        $comment->ip_address  = $request->ip();
        $comment->status = 1;
        $comment->save();


        return redirect()
            ->back()
            ->with('success', 'Your comment has been submitted and is awaiting moderation.');
    }

    public function gallery(Request $request)
    {
        $query = Picture::where('type', 'gallery');

        // Sort filter
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'random':
                $query->inRandomOrder();
                break;
            case 'name':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $pictures = $query->paginate(12)
            ->withQueryString();

        $categories = Category::where('status', 1)->get();
        $recentPictures = Picture::where('type', 'gallery')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return view('frontend.gallery', compact('pictures', 'categories', 'recentPictures'));
    }




    public function about()
    {


        // Personal information
        $personalInfo = [
            'name' => 'Alex', // Change this to your name
            'role' => 'Storyteller & Explorer',
            'location' => 'Somewhere Beautiful',
            'bio' => 'A curious soul wandering through life with a camera in hand and stories in heart.',
            'mission' => 'To capture the beauty in ordinary moments and share stories that connect us all.',
            'quote' => '"The world is full of stories waiting to be told, and I\'m here to listen."',
            'interests' => ['Photography', 'Writing', 'Hiking', 'Coffee Brewing', 'Reading', 'Stargazing'],
            'gear' => [
                ['name' => 'Camera', 'detail' => 'Canon EOS R5'],
                ['name' => 'Favorite Lens', 'detail' => '24-70mm f/2.8'],
                ['name' => 'Editing Software', 'detail' => 'Lightroom & Photoshop'],
                ['name' => 'Travel Companion', 'detail' => 'Trusty Backpack']
            ]
        ];

        // Get some stats from database
        $stats = [
            'totalPosts' => Post::where('status', 'published')->count(),
            'totalPhotos' => Picture::where('type', 'gallery')->count(),
            'countriesFeatured' => 24, // You can calculate this from your posts/pictures
            'yearsWriting' => date('Y') - 2018 // Since 2018
        ];

        $journey = [
            ['year' => '2018', 'title' => 'The First Click', 'description' => 'Started documenting my daily life with a simple point-and-shoot camera.'],
            ['year' => '2019', 'title' => 'Finding My Voice', 'description' => 'Began writing alongside photos, discovering the power of combined storytelling.'],
            ['year' => '2020', 'title' => 'Going Digital', 'description' => 'Created My World blog to share my journey beyond social media.'],
            ['year' => '2021', 'title' => 'First Solo Trip', 'description' => 'Traveled across the country, documenting every moment of self-discovery.'],
            ['year' => '2022', 'title' => 'Finding Community', 'description' => 'Connected with fellow creators and started meaningful collaborations.'],
            ['year' => '2023', 'title' => 'New Perspective', 'description' => 'Redesigned My World to focus on authentic, meaningful storytelling.'],
        ];

        $values = [
            ['icon' => 'fas fa-heart', 'title' => 'Authenticity', 'description' => 'Keeping it real - no filters, no pretenses.'],
            ['icon' => 'fas fa-compass', 'title' => 'Curiosity', 'description' => 'Always exploring, always learning, always wondering.'],
            ['icon' => 'fas fa-hands', 'title' => 'Connection', 'description' => 'Building bridges through shared stories and experiences.'],
            ['icon' => 'fas fa-sun', 'title' => 'Positivity', 'description' => 'Finding light even in challenging moments.'],
        ];

        $favorites = [
            ['type' => 'Camera Gear', 'items' => ['Canon EOS R5', '24-70mm Lens', 'Tripod', 'Polarizing Filters']],
            ['type' => 'Travel Essentials', 'items' => ['Journal', 'Coffee Kit', 'Comfortable Shoes', 'Portable Charger']],
            ['type' => 'Creative Tools', 'items' => ['Moleskine Notebook', 'Fountain Pen', 'iPad Pro', 'Noise-canceling Headphones']],
            ['type' => 'Reading List', 'items' => ['Into the Wild', 'The Alchemist', 'Wild', 'The Photographer\'s Eye']],
        ];

        return view('frontend.about', compact('personalInfo', 'stats', 'journey', 'values', 'favorites'));
    }

    public function contact()
    {
        $contactInfo = [
            'email' => 'hello@myworld.com',
            'phone' => '+1 (555) 123-4567',
            'address' => '123 Creative Street, Inspiration City, IC 12345',
            'social' => [
                ['platform' => 'instagram', 'url' => '#', 'icon' => 'fab fa-instagram', 'handle' => '@myworld'],
                ['platform' => 'twitter', 'url' => '#', 'icon' => 'fab fa-twitter', 'handle' => '@myworld'],
                ['platform' => 'pinterest', 'url' => '#', 'icon' => 'fab fa-pinterest', 'handle' => '@myworld'],
                ['platform' => 'youtube', 'url' => '#', 'icon' => 'fab fa-youtube', 'handle' => 'My World'],
            ],
            'businessHours' => [
                ['day' => 'Monday - Friday', 'hours' => '9:00 AM - 6:00 PM', 'status' => 'open'],
                ['day' => 'Saturday', 'hours' => '10:00 AM - 4:00 PM', 'status' => 'limited'],
                ['day' => 'Sunday', 'hours' => 'Closed', 'status' => 'closed'],
            ],
            'faqs' => [
                [
                    'question' => 'How long does it take to get a response?',
                    'answer' => 'I typically respond within 24-48 hours on weekdays. Weekend responses may take longer.'
                ],
                [
                    'question' => 'Do you accept guest posts?',
                    'answer' => 'Yes! I welcome guest posts that align with my blog\'s theme. Please email me your pitch with a brief outline of your proposed article.'
                ],
                [
                    'question' => 'Can I use your photos for personal projects?',
                    'answer' => 'Most photos are available for personal, non-commercial use with proper attribution. For commercial use, please contact me directly for licensing information.'
                ],
                [
                    'question' => 'Do you offer photography services?',
                    'answer' => 'Yes, I offer limited photography services for select projects. Email me with details about your project and I\'ll let you know if I can help.'
                ],
                [
                    'question' => 'Can I collaborate with you?',
                    'answer' => 'Absolutely! I\'m always open to creative collaborations. Send me your proposal and let\'s discuss how we can work together.'
                ],
                [
                    'question' => 'Do you have a newsletter?',
                    'answer' => 'Yes! You can subscribe to my newsletter on the homepage to get updates about new posts, photos, and behind-the-scenes content.'
                ],
            ],
            'responseTime' => '24-48 hours',
            'emergencyContact' => 'For urgent matters, please call during business hours.',
            'preferredContact' => 'Email is the best way to reach me for non-urgent matters.',
        ];

        return view('frontend.contact', compact('contactInfo'));
    }

    public function sendMessage(Request $request)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:2000',
        ];

        $messages = [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'subject.required' => 'Please enter a subject.',
            'message.required' => 'Please enter your message.',
            'message.min' => 'Your message should be at least 10 characters.',
            'message.max' => 'Your message should not exceed 2000 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()
                ->route('contact.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the errors below.');
        }

        try {
            if (class_exists(ContactMessage::class)) {
                ContactMessage::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'subject' => $request->subject,
                    'message' => $request->message,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'status' => 'unread',
                ]);
            }

            ///$this->sendEmailNotification($request->all());
            Log::info('New contact form submission received:', [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'ip' => $request->ip(),
            ]);
            return redirect()
                ->route('contact.index')
                ->with('success', 'Thank you for your message! I\'ll get back to you within 24-48 hours.');
        } catch (\Exception $e) {
            Log::error('Contact form submission failed:', [
                'error' => $e->getMessage(),
                'data' => $request->except('message'),
            ]);
            return redirect()
                ->route('contact.index')
                ->with('error', 'Something went wrong. Please try again later.')
                ->withInput();
        }
    }
}
