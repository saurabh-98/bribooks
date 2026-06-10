<?php

namespace App\Services;

class ModerationService
{
    /**
     * Restricted / prohibited words
     */
    protected array $restrictedWords = [
        'terrorism',
        'extremism',
        'illegal',
        'violence',
        'bomb',
        'explosive',
        'weapon',
        'attack',
    ];

    /**
     * Profanity words
     */
    protected array $profanityWords = [
        'idiot',
        'abuse',
        'profanity',
        'offensiveword1',
        'offensiveword2',
    ];

    /**
     * Moderate content
     */
    public function moderate(
        string $content
    ): array {

        $violations = $this->getViolations(
            $content
        );

        return [
            'passed' => empty(
                $violations
            ),
            'violations' => $violations,
        ];
    }

    /**
     * Validate content
     */
    public function validate(
        string $content
    ): bool {

        return empty(
            $this->getViolations(
                $content
            )
        );
    }

    /**
     * Check restricted words only
     */
    public function checkRestrictedWords(
        string $content
    ): bool {

        $content = strtolower(
            $content
        );

        foreach (
            $this->restrictedWords
            as $word
        ) {

            if (
                str_contains(
                    $content,
                    strtolower($word)
                )
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check profanity only
     */
    public function checkProfanity(
        string $content
    ): bool {

        $content = strtolower(
            $content
        );

        foreach (
            $this->profanityWords
            as $word
        ) {

            if (
                str_contains(
                    $content,
                    strtolower($word)
                )
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Return all violations found
     */
    public function getViolations(
        string $content
    ): array {

        $violations = [];

        $content = strtolower(
            $content
        );

        foreach (
            array_merge(
                $this->restrictedWords,
                $this->profanityWords
            )
            as $word
        ) {

            if (
                str_contains(
                    $content,
                    strtolower($word)
                )
            ) {

                $violations[] = $word;
            }
        }

        return array_values(
            array_unique(
                $violations
            )
        );
    }
}