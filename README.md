# Translation Management Service (Laravel API)

This is an API-based Translation Management Service built using Laravel, designed for scalability, performance, and clean architecture. It allows storing and retrieving translations across multiple locales and tagging them for contextual usage. This project follows SOLID principles and PSR-12 coding standards.

## Features

- Token-based API authentication using Laravel Sanctum
- Store translations across locales (e.g., `en`, `fr`, `es`)
- Associate translations with tags (e.g., `web`, `mobile`)
- Search translations by tag, key, or content
- JSON export endpoint for frontend integration (e.g., Vue.js)
- Optimized for performance (<200ms for all endpoints)
- Database seeding with 100,000+ records for scalability testing
- Redis support for caching and queue drivers
- Unit-tested with >95% code coverage

## Technologies

- Laravel 10
- Sanctum (Token-based authentication)
- MySQL (using custom port `3306`)
- Redis (using custom port `6379`)
- PHPUnit (feature and unit testing)

## Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL on port 3306
- Redis on port 6379
- Laravel CLI installed (optional but recommended)

### Installation

1. Clone the repository:

```bash
git clone https://github.com/ihammadhashmi/translation-management.git
cd translation-management



## Testing

### Create Test Environment

To configure a dedicated test database:

1. Duplicate your existing `.env` file:

```bash
cp .env .env.testing
