# Contributing to WP Wingman

Thank you for your interest in contributing to WP Wingman! This document provides guidelines and instructions for contributing.

## Code of Conduct

By participating in this project, you agree to maintain a respectful and inclusive environment for everyone.

## How to Contribute

### Reporting Bugs

1. Check if the bug has already been reported in [Issues](https://github.com/wpclinic/hustlemate/issues)
2. If not, create a new issue with:
   - Clear, descriptive title
   - Detailed description of the bug
   - Steps to reproduce
   - Expected vs actual behavior
   - Screenshots (if applicable)
   - Environment details (OS, browser, PHP/Node version)

### Suggesting Features

1. Check existing issues and discussions
2. Create a new issue with tag `enhancement`
3. Describe the feature and use case
4. Explain why it would be beneficial

### Pull Requests

#### Before Starting

1. Fork the repository
2. Create a new branch from `develop`
3. Discuss major changes in an issue first

#### Branch Naming

- `feature/feature-name` - New features
- `bugfix/bug-description` - Bug fixes
- `hotfix/critical-fix` - Critical production fixes
- `docs/documentation-topic` - Documentation updates

#### Development Setup

```bash
# Clone your fork
git clone https://github.com/your-username/hustlemate.git
cd hustlemate

# Add upstream remote
git remote add upstream https://github.com/wpclinic/hustlemate.git

# Create a new branch
git checkout -b feature/your-feature-name

# Install dependencies
cd backend && composer install
cd ../admin-dashboard && npm install
cd ../client-portal && npm install
```

#### Code Style

**Backend (PHP/Laravel)**
- Follow PSR-12 coding standard
- Use Laravel Pint for formatting: `./vendor/bin/pint`
- Write PHPDoc comments for classes and methods
- Use type hints

**Frontend (Vue/TypeScript)**
- Follow Vue 3 Composition API style guide
- Use ESLint: `npm run lint`
- Write TypeScript with proper types
- Use Prettier for formatting

#### Testing

**Backend Tests**
```bash
cd backend
php artisan test
```

**Frontend Tests**
```bash
cd admin-dashboard
npm run test
```

#### Commit Messages

Follow conventional commits format:

```
type(scope): description

[optional body]

[optional footer]
```

Types:
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting)
- `refactor`: Code refactoring
- `test`: Adding/updating tests
- `chore`: Maintenance tasks

Examples:
```
feat(api): add site backup endpoint
fix(dashboard): resolve chart rendering issue
docs(readme): update installation instructions
```

#### Pull Request Process

1. Update your branch with latest changes:
   ```bash
   git fetch upstream
   git rebase upstream/develop
   ```

2. Ensure all tests pass
3. Update documentation if needed
4. Push to your fork:
   ```bash
   git push origin feature/your-feature-name
   ```

5. Create Pull Request with:
   - Clear title and description
   - Reference related issues
   - Screenshots for UI changes
   - List of changes made

6. Address review feedback
7. Once approved, maintainers will merge

### Code Review Guidelines

Reviewers will check for:
- Code quality and style
- Test coverage
- Documentation
- Performance implications
- Security concerns
- Breaking changes

## Project Structure

```
hustlemate/
├── backend/              # Laravel API
│   ├── app/
│   ├── database/
│   ├── routes/
│   └── tests/
├── admin-dashboard/      # Vue admin interface
│   ├── src/
│   ├── public/
│   └── tests/
├── client-portal/        # Vue client interface
│   ├── src/
│   ├── public/
│   └── tests/
├── wordpress-plugin/     # WordPress plugin
│   ├── includes/
│   ├── admin/
│   └── assets/
├── landing-page/         # Marketing site
│   ├── src/
│   └── public/
└── docs/                 # Documentation
```

## Development Workflow

### Running Locally

```bash
# Start all services
docker-compose up -d

# View logs
docker-compose logs -f

# Stop services
docker-compose down
```

### Database Migrations

```bash
cd backend

# Create migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback
php artisan migrate:rollback
```

### Adding Dependencies

**Backend**
```bash
cd backend
composer require package-name
```

**Frontend**
```bash
cd admin-dashboard
npm install package-name
```

## Security

If you discover a security vulnerability:

1. **DO NOT** open a public issue
2. Email security@wpwingman.com
3. Include:
   - Description of vulnerability
   - Steps to reproduce
   - Potential impact
   - Suggested fix (if any)

We will respond within 48 hours.

## License

By contributing, you agree that your contributions will be licensed under the same license as the project (GPL-2.0).

## Questions?

- Open a discussion in GitHub Discussions
- Join our community chat
- Email: dev@wpwingman.com

## Recognition

Contributors will be acknowledged in:
- CONTRIBUTORS.md file
- Release notes
- Project website

Thank you for contributing to WP Wingman! 🎉
