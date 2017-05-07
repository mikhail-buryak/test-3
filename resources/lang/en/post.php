<?php

return [
    'index' => [
        'title' => 'Posts',
        'description' => 'Index paginate page of all posts',
        'read_more' => 'Read more',
        'create' => 'Create Post',
        'search' => 'Search by tags',
    ],

    'posted_on' => 'Posted on',
    'tags' => 'Tags',
    'by' => 'by',
    'without_author' => 'UFO',
    'back' => 'Back to posts',

    'process' => [
        'success' => [
            'title' => 'Post created',
            'text_0' => 'Your post saved, you can see it on index page',
            'text_1' => 'Awesome, go to index page',
        ],
        'error' => [
            'title' => 'The following errors occurred',
            'text_0' => 'Close',
        ],
    ],

    'create' => [
        'title' => 'Create a new post',
        'part' => [
            'title' => 'Post title',
            'body' => 'Post content(body)',
            'image' => 'Post picture',
            'tags' => 'Post search tags',
            'created_at' => 'Post Created At Date',
            'create' => 'Create a Post',
        ],

        'valid' => [
            'title' => [
                'empty' => 'Title field should be not empty',
                'length' => 'The title must be more than 1 and less than 200 characters long'
            ],
            'body' => [
                'empty' => 'Body field should be not empty',
            ],
            'created_at' => [
                'empty' => 'Created At field should be not empty',
                'date' => 'The value is not a valid date'
            ],
        ],

        'success' => [
            'title' => 'New post created',
            'text' => 'Your post created and you can view it on index page',
            'confirm' => 'Awesome, go to index page',
        ],

        'error' => [
            'title' => 'Houston, we have a problem',
            'confirm' => 'Close',
        ],
        'read_more' => 'Read more',
        'create' => 'Create Post',
        'search' => 'Search by tags',
    ],


];
