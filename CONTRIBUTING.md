# CONTRIBUTING GUIDE

## 🤝 Contributing to Pawn Broker Application

Thank you for your interest in contributing to the Pawn Broker Application! This document provides guidelines and instructions for contributing to the project.

---

## 📋 Table of Contents

1. [Code of Conduct](#code-of-conduct)
2. [Getting Started](#getting-started)
3. [Development Workflow](#development-workflow)
4. [Coding Standards](#coding-standards)
5. [Commit Guidelines](#commit-guidelines)
6. [Pull Request Process](#pull-request-process)
7. [Testing Requirements](#testing-requirements)
8. [Documentation](#documentation)

---

## Code of Conduct

### Our Pledge

We are committed to providing a welcoming and inspiring community for all. Please be respectful and constructive in all interactions.

### Expected Behavior

- Use welcoming and inclusive language
- Be respectful of differing viewpoints
- Accept constructive criticism gracefully
- Focus on what is best for the community
- Show empathy towards other community members

### Unacceptable Behavior

- Harassment or discriminatory language
- Trolling or insulting comments
- Public or private harassment
- Publishing others' private information
- Other conduct which could reasonably be considered inappropriate

---

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 18.x or higher
- MySQL 8.0 or MariaDB 10.6+
- Git

### Fork and Clone

1. Fork the repository on GitHub
2. Clone your fork locally:

```bash
git clone https://github.com/YOUR_USERNAME/pawn-broker.git
cd pawn-broker
```

3. Add upstream remote:

```bash
git remote add upstream https://github.com/ORIGINAL_OWNER/pawn-broker.git
```

### Local Setup

1. Install PHP dependencies:

```bash
composer install
```

2. Install Node dependencies:

```bash
npm install
```

3. Copy environment file:

```bash
cp .env.example .env
```

4. Generate application key:

```bash
php artisan key:generate
```

5. Create database and configure `.env`:

```env
DB_DATABASE=pawn_broker_dev
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations:

```bash
php artisan migrate
php artisan db:seed
```

7. Create storage link:

```bash
php artisan storage:link
```

8. Build assets:

```bash
npm run dev
```

9. Start development server:

```bash
php artisan serve
```

---

## Development Workflow

### Branching Strategy

We use Git Flow branching model:

- **main**: Production-ready code
- **develop**: Integration branch for features
- **feature/**: New features (`feature/add-sms-notifications`)
- **bugfix/**: Bug fixes (`bugfix/fix-interest-calculation`)
- **hotfix/**: Urgent production fixes (`hotfix/security-patch`)
- **release/**: Release preparation (`release/v1.1.0`)

### Creating a Feature Branch

```bash
# Update develop branch
git checkout develop
git pull upstream develop

# Create feature branch
git checkout -b feature/your-feature-name
```

### Making Changes

1. Make your changes in the feature branch
2. Write/update tests
3. Update documentation
4. Test thoroughly
5. Commit with meaningful messages

### Keeping Your Branch Updated

```bash
# Fetch upstream changes
git fetch upstream

# Rebase your branch
git rebase upstream/develop
```

---

## Coding Standards

### PHP Code Style

We follow **PSR-12** coding standard.

#### Install PHP CS Fixer

```bash
composer require --dev friendsofphp/php-cs-fixer
```

#### Run Code Fixer

```bash
vendor/bin/php-cs-fixer fix
```

### Laravel Best Practices

#### Controllers

- Keep controllers thin
- Use Form Requests for validation
- Use Resource Controllers when possible
- Return views or redirects, not JSON (unless API)

**Good Example**:

```php
public function store(StoreCustomerRequest $request)
{
    $customer = Customer::create($request->validated());
    
    return redirect()
        ->route('customers.show', $customer)
        ->with('success', 'Customer created successfully');
}
```

**Bad Example**:

```php
public function store(Request $request)
{
    // Validation in controller
    $request->validate([...]);
    
    // Complex business logic in controller
    $customer = new Customer();
    $customer->name = $request->name;
    // ... many lines of code
    
    return response()->json(['message' => 'Success']);
}
```

#### Models

- Use Eloquent relationships
- Define fillable or guarded properties
- Use accessors/mutators for data transformation
- Add model events when needed

**Example**:

```php
class Customer extends Model
{
    protected $fillable = ['name', 'mobile', 'address'];
    
    protected $casts = [
        'created_at' => 'datetime',
    ];
    
    // Relationship
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
    
    // Accessor
    public function getFormattedMobileAttribute()
    {
        return '+91 ' . $this->mobile;
    }
}
```

#### Services

- Extract complex business logic to services
- Make services testable
- Use dependency injection

**Example**:

```php
class InterestCalculationService
{
    public function calculateFlatInterest(
        float $principal, 
        float $rate, 
        int $days
    ): float {
        return ($principal * $rate * $days) / 30;
    }
}
```

### JavaScript Code Style

- Use ES6+ syntax
- Use `const` and `let`, avoid `var`
- Use arrow functions when appropriate
- Add comments for complex logic

### Blade Templates

- Use Blade components for reusable UI
- Escape output with `{{ }}` (not `{!! !!}` unless necessary)
- Keep logic minimal in views
- Use `@auth`, `@guest` directives

### Database

- Always use migrations for schema changes
- Never edit migration files after they're committed
- Create new migration for changes
- Use descriptive migration names
- Add indexes for foreign keys and frequently queried columns

---

## Commit Guidelines

### Commit Message Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

- **feat**: New feature
- **fix**: Bug fix
- **docs**: Documentation changes
- **style**: Code style changes (formatting, etc.)
- **refactor**: Code refactoring
- **test**: Adding or updating tests
- **chore**: Maintenance tasks

### Examples

```
feat(customers): add photo upload functionality

- Added photo field to customers table
- Implemented file upload in CustomerController
- Added validation for image files
- Updated customer form view

Closes #123
```

```
fix(loans): correct interest calculation for reducing balance

The reducing balance interest was being calculated on principal
instead of outstanding amount. Fixed to use outstanding_principal.

Fixes #456
```

### Commit Best Practices

- Write clear, concise commit messages
- Use present tense ("add feature" not "added feature")
- Reference issue numbers when applicable
- Keep commits focused (one logical change per commit)
- Commit often, push regularly

---

## Pull Request Process

### Before Submitting

1. **Update your branch**:

```bash
git fetch upstream
git rebase upstream/develop
```

2. **Run tests**:

```bash
php artisan test
```

3. **Check code style**:

```bash
vendor/bin/php-cs-fixer fix
```

4. **Update documentation** if needed

5. **Test manually** in browser

### Creating Pull Request

1. Push your branch to your fork:

```bash
git push origin feature/your-feature-name
```

2. Go to GitHub and create Pull Request

3. Fill in the PR template:

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
- [ ] Unit tests pass
- [ ] Feature tests pass
- [ ] Manual testing completed

## Screenshots (if applicable)
Add screenshots here

## Checklist
- [ ] Code follows project style guidelines
- [ ] Self-review completed
- [ ] Comments added for complex code
- [ ] Documentation updated
- [ ] No new warnings generated
- [ ] Tests added/updated
```

### PR Review Process

1. **Automated Checks**: CI/CD runs tests automatically
2. **Code Review**: Maintainers review your code
3. **Feedback**: Address any requested changes
4. **Approval**: Once approved, PR will be merged

### After PR is Merged

1. Delete your feature branch:

```bash
git branch -d feature/your-feature-name
git push origin --delete feature/your-feature-name
```

2. Update your local develop:

```bash
git checkout develop
git pull upstream develop
```

---

## Testing Requirements

### Required Tests

All contributions must include appropriate tests:

#### For New Features

- Unit tests for models and services
- Feature tests for controllers
- Browser tests for UI changes (if applicable)

#### For Bug Fixes

- Test that reproduces the bug
- Test that verifies the fix

### Running Tests

```bash
# All tests
php artisan test

# Specific test file
php artisan test tests/Feature/CustomerTest.php

# With coverage
php artisan test --coverage --min=75
```

### Test Coverage

- Aim for 75%+ overall coverage
- New code should have 80%+ coverage
- Critical business logic should have 90%+ coverage

---

## Documentation

### Code Documentation

- Add PHPDoc blocks for all classes and methods
- Document complex algorithms
- Explain "why" not just "what"

**Example**:

```php
/**
 * Calculate flat interest for a loan.
 * 
 * Formula: (Principal × Rate × Days) / 30
 * Rate is per month, so we divide by 30 days
 *
 * @param float $principal Loan principal amount
 * @param float $rate Interest rate per month (as percentage)
 * @param int $days Number of days
 * @return float Calculated interest amount
 */
public function calculateFlatInterest(float $principal, float $rate, int $days): float
{
    return ($principal * $rate * $days) / 30;
}
```

### User Documentation

Update relevant documentation files:

- `README.md`: Project overview
- `USER_MANUAL.md`: End-user instructions
- `API_DOCUMENTATION.md`: API changes
- `DATABASE_SCHEMA.md`: Schema changes

---

## Issue Reporting

### Bug Reports

Include:

- Clear title
- Steps to reproduce
- Expected behavior
- Actual behavior
- Screenshots (if applicable)
- Environment details (PHP version, OS, browser)

### Feature Requests

Include:

- Clear description of feature
- Use case/business value
- Proposed implementation (optional)
- Mockups/wireframes (if applicable)

---

## Development Tips

### Useful Commands

```bash
# Clear all caches
php artisan optimize:clear

# Generate IDE helper files
php artisan ide-helper:generate
php artisan ide-helper:models

# Run code analysis
vendor/bin/phpstan analyse

# Database refresh with seeding
php artisan migrate:fresh --seed

# Watch assets for changes
npm run dev
```

### Debugging

- Use `dd()` and `dump()` for quick debugging
- Use Laravel Telescope for advanced debugging (install separately)
- Check `storage/logs/laravel.log` for errors
- Use browser DevTools for frontend issues

### Performance

- Use eager loading to avoid N+1 queries
- Cache frequently accessed data
- Optimize database queries
- Use queue for long-running tasks

---

## Getting Help

### Resources

- **Documentation**: Check existing docs first
- **Issues**: Search existing issues
- **Discussions**: Use GitHub Discussions for questions

### Contact

- **Email**: dev@pawnbroker.com
- **Discord**: [Join our server](#)
- **Stack Overflow**: Tag with `pawn-broker-app`

---

## Recognition

Contributors will be:

- Listed in `CONTRIBUTORS.md`
- Mentioned in release notes
- Credited in documentation

---

## License

By contributing, you agree that your contributions will be licensed under the same license as the project (MIT License).

---

**Thank you for contributing to Pawn Broker Application!** 🎉

---

**Contributing Guide Version**: 1.0.0  
**Last Updated**: December 21, 2025
