<?php

namespace App\Helpers;

class SearchHelper
{
    /**
     * Escape LIKE wildcard characters in search terms to prevent wildcard injection.
     *
     * Escapes the following characters:
     * - % (matches any sequence of characters)
     * - _ (matches any single character)
     * - \ (escape character itself)
     *
     * @param string|null $term The search term to escape
     * @return string|null The escaped search term
     */
    public static function escapeLikeWildcards(?string $term): ?string
    {
        if ($term === null || $term === '') {
            return $term;
        }

        // Escape the backslash first to prevent double-escaping
        $term = str_replace('\\', '\\\\', $term);
        // Then escape LIKE wildcards
        $term = str_replace('%', '\%', $term);
        $term = str_replace('_', '\_', $term);

        return $term;
    }
}
