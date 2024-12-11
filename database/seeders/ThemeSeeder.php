<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\File;
use App\Models\WpMaterial;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run()
    {
        // Seed the Astra theme
        $this->seedTheme(
            'astra.zip',
            'Astra',
            'Astra is a fast, lightweight, and highly customizable theme.',
            1
        );
        // Seed the Zakra theme
        $this->seedTheme(
            'zakra.zip',
            'Zakra',
            'Zakra is a powerful and versatile multipurpose theme that makes it easy to create beautiful and professional websites. With over 40 free pre-designed starter demo sites to choose from, you can quickly build a unique and functional site that fits your specific needs. Whether you\'re launching a blog, news site, e-commerce store, showcasing your portfolio, building a business site, LMS, or niche-specific site (such as a cafe, spa, charity, yoga studio, wedding venue, dental practice, photography, restaurant, or educational institution), Zakra has everything you need to succeed. The theme integrates seamlessly with popular page builders like Elementor, Brizy, BlockArt, and the Gutenberg editor, giving you complete freedom to create any layout you can imagine. Importantly, Zakra is optimized for speed, features a mobile-first responsive design, is built with block-based technology, and is optimized for search engines. It is also compatible with a wide range of popular WordPress plugins, allowing you to extend its functionality as needed. Build your next project with Zakra today and see the difference for yourself. Check out all the starter sites at https://zakratheme.com/demos!',
            2
        );

        $this->seedTheme(
            'variations.zip',
            'Variations',
            'Variations is a block theme and hopefully the last theme you will even have to install. It comes with many different templates and block patterns to make creating a website easy.',
            3
        );
        $this->seedTheme(
            'moonlit-dark.zip',
            'Moonlit Dark',
            'Moonlit Dark is a visually striking WordPress blog theme crafted by CA WP Themes. With its elegant and modern design, this theme is perfect for bloggers who want to create a captivating online presence.The Moonlit Dark theme features a sleek and dark color scheme that adds a touch of sophistication to your blog. Its clean layout ensures that your content takes center stage, allowing your readers to focus on your articles and stories. Whether you are a fashion blogger, a travel enthusiast, or a creative writer, Moonlit Dark provides an ideal canvas to showcase your work.This theme is fully responsive and optimized for various devices, ensuring that your blog looks fantastic on desktops, tablets, and smartphones. Its user-friendly interface makes it easy to navigate and interact with your content, offering a seamless reading experience for your visitors.Documentation: https://cawpthemes.com/docs/moonlit-free-theme-documentation/ . Details: https://cawpthemes.com/moonlit-dark-blog-theme/',
            4
        );
    }



    private function seedTheme(string $fileName, string $name, string $description, int $categoryId)
    {
        $sourceFilePath = public_path('Import_mysql/' . $fileName);
        $themeDirectory = public_path('wp-themes');

        // Ensure the target directory exists
        if (!File::exists($themeDirectory)) {
            File::makeDirectory($themeDirectory, 0775, true);
        }

        // Check if the directory is writable
        if (!is_writable($themeDirectory)) {
            echo "The wp-themes directory is not writable.\n";
            return;
        }

        // Define the target file path
        $targetFilePath = $themeDirectory . '/' . $fileName;

        // Copy the file
        if (File::exists($sourceFilePath)) {
            File::copy($sourceFilePath, $targetFilePath);
        } else {
            echo "Source file does not exist: " . $sourceFilePath . "\n";
            return;
        }

        // Set the file permissions
        chmod($targetFilePath, 0775);

        // Create a record for the uploaded theme
        $theme = new WpMaterial();
        $theme->name = $name;
        $theme->slug = $name;
        $theme->file_path = 'wp-themes/' . $fileName;
        $theme->description = $description;
        $theme->type = 'wp-themes';
        $theme->status = 'installed';
        $theme->category_id = $categoryId;
        $theme->save();
    }
}
