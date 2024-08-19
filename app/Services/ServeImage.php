<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ServeImage
{
    /**
     * Generate the URL for an image based on its type.
     *
     * @param string|null $path The image path.
     * @param string $type The image type ('main' or other variations).
     * @return string The URL of the image.
     */
    public static function image($path, $type = 'main')
    {
        // Default image URL if path is empty
        if (empty($path)) {
            return self::defaultImageUrl();
        }

        // Determine if it's the main image or a type variant
        if ($type === 'main') {
            return self::getImageUrl($path);
        } else {
            return self::getVariantImageUrl($path, $type);
        }
    }

    /**
     * Get the URL for the user's profile image.
     *
     * @param \App\Models\User|null $user The user instance.
     * @param string $type The image type ('main' or other variations).
     * @return string The URL of the profile image.
     */
    public static function profile($user, $type = 'main')
    {
        if (!$user || empty($user->image)) {
            return self::defaultAvatarUrl($user);
        }

        $path = $user->image;
        if ($type === 'main') {
            return self::getImageUrl($path);
        } else {
            return self::getVariantImageUrl($path, $type);
        }
    }

    /**
     * Get the URL for an image if it exists, otherwise return the default image.
     *
     * @param string $path The image path.
     * @return string The URL of the image.
     */
    private static function getImageUrl($path)
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }
        return self::defaultImageUrl();
    }

    /**
     * Get the URL for a variant image type if it exists, otherwise return the default image.
     *
     * @param string $path The original image path.
     * @param string $type The image type ('thumbnail', 'small', etc.).
     * @return string The URL of the variant image.
     */
    private static function getVariantImageUrl($path, $type)
    {
        $fileBaseName = pathinfo($path, PATHINFO_FILENAME);
        $fileExtension = pathinfo($path, PATHINFO_EXTENSION);
        $variantPath = $fileBaseName . '_' . $type . '.' . $fileExtension;
        // get the path without file name
        $path = pathinfo($path, PATHINFO_DIRNAME);
        $variantPath = $path . '/' . $variantPath;
        if (Storage::disk('public')->exists($variantPath)) {
            return Storage::url($variantPath);
        }
        return self::defaultImageUrl();
    }

    /**
     * Get the URL for the default image.
     *
     * @return string The URL of the default image.
     */
    private static function defaultImageUrl()
    {
        return Storage::url('assets/img/default_book_vector.jpg');
    }

    /**
     * Get the URL for the default avatar image if user image is not available.
     *
     * @param \App\Models\User|null $user The user instance.
     * @return string The URL of the default avatar image.
     */
    private static function defaultAvatarUrl($user)
    {
        $name = $user ? $user->first_name . '+' . $user->last_name : 'Guest';
        return 'https://ui-avatars.com/api/?name=' . $name . '&background=0D8ABC&color=fff';
    }
}
