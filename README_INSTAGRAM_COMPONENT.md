# Instagram Embeds Component

A reusable Laravel Blade component for displaying Instagram posts with embedded content.

## Features

- **Responsive Design**: Adapts to different screen sizes with a responsive grid layout
- **Real Instagram Embeds**: Uses actual Instagram embed iframes for authentic content
- **Customizable**: Accepts props for title, subtitle, and Instagram post IDs
- **Multilingual Support**: Includes English and Arabic translations
- **Hover Effects**: Smooth animations and hover effects for better user experience
- **RTL Support**: Proper right-to-left layout support for Arabic language

## Usage

### Basic Usage

```blade
<!-- Use with default settings -->
<x-instagram-embeds />
```

### Custom Title and Subtitle

```blade
<!-- Custom title and subtitle -->
<x-instagram-embeds 
    title="Our Latest Posts" 
    subtitle="Check out what's happening at Hadaf" 
/>
```

### Custom Instagram Posts

```blade
<!-- Custom Instagram post IDs -->
<x-instagram-embeds 
    :posts="['C8XqXqXqXqX', 'C8YqYqYqYqY', 'C8ZqZqZqZqZ']"
/>
```

### Full Customization

```blade
<!-- Full customization -->
<x-instagram-embeds 
    title="Follow Our Journey" 
    subtitle="See behind the scenes at Hadaf"
    :posts="['C8XqXqXqXqX', 'C8YqYqYqYqY', 'C8ZqZqZqZqZ']"
/>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | string | null | Custom title for the section. If null, uses translation key |
| `subtitle` | string | null | Custom subtitle for the section. If null, uses translation key |
| `posts` | array | ['C8XqXqXqXqX', 'C8YqYqYqYqY', 'C8ZqZqZqZqZ'] | Array of Instagram post IDs to display |

## Translation Keys

The component uses the following translation keys:

### English (`lang/en/words.php`)
```php
'instagram' => [
    'title' => 'Follow Us on Instagram',
    'subtitle' => 'Stay updated with our latest news and opportunities',
    'follow_button' => 'Follow on Instagram'
]
```

### Arabic (`lang/ar/words.php`)
```php
'instagram' => [
    'title' => 'تابعنا على إنستغرام',
    'subtitle' => 'ابق على اطلاع بآخر الأخبار والفرص',
    'follow_button' => 'تابع على إنستغرام'
]
```

## Instagram Post IDs

To get Instagram post IDs:

1. Go to the Instagram post you want to embed
2. Click the three dots (...) and select "Copy Link"
3. The link will look like: `https://www.instagram.com/p/C8XqXqXqXqX/`
4. The part after `/p/` is your post ID: `C8XqXqXqXqX`

## Styling

The component uses Tailwind CSS classes and includes:

- Responsive grid layout (1 column on mobile, 2 on tablet, 3 on desktop)
- Hover effects with smooth transitions
- Instagram-branded color scheme (purple to pink gradients)
- Shadow effects and rounded corners
- Proper spacing and typography

## Customization

### Changing Colors
Modify the gradient classes in the component:
```blade
<!-- Change from purple-pink to blue gradient -->
<div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-400 rounded-full">
```

### Changing Layout
Modify the grid classes:
```blade
<!-- Change to 4 columns on large screens -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
```

### Adding More Posts
Simply add more post IDs to the posts array:
```blade
<x-instagram-embeds 
    :posts="['C8XqXqXqXqX', 'C8YqYqYqYqY', 'C8ZqZqZqZqZ', 'C8AqAqAqAqAq']"
/>
```

## Browser Compatibility

- Modern browsers with iframe support
- Instagram embed requires internet connection
- Responsive design works on all device sizes

## Notes

- Instagram embeds may take a moment to load
- Post engagement numbers (likes, comments) are currently hardcoded for demonstration
- The component automatically handles RTL layout for Arabic language
- All links open in new tabs for better user experience
