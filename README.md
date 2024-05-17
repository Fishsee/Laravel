# Code conventies backend-Laravel



## Volg de Laravel naming conventions

Volg [PSR standards](https://www.php-fig.org/psr/psr-12/).


What | How | Good | Bad
------------ | ------------- | ------------- | -------------
Controller | singular | ArticleController | ~~ArticlesController~~
Route | plural | articles/1 | ~~article/1~~
Route name | snake_case with dot notation | users.show_active | ~~users.show-active, show-active-users~~
Model | singular | User | ~~Users~~
hasOne or belongsTo relationship | singular | articleComment | ~~articleComments, article_comment~~
All other relationships | plural | articleComments | ~~articleComment, article_comments~~
Table | plural | article_comments | ~~article_comment, articleComments~~
Pivot table | singular model names in alphabetical order | article_user | ~~user_article, articles_users~~
Table column | snake_case without model name | meta_title | ~~MetaTitle; article_meta_title~~
Model property | snake_case | $model->created_at | ~~$model->createdAt~~
Foreign key | singular model name with _id suffix | article_id | ~~ArticleId, id_article, articles_id~~
Primary key | - | id | ~~custom_id~~
Migration | - | 2017_01_01_000000_create_articles_table | ~~2017_01_01_000000_articles~~
Method | camelCase | getAll | ~~get_all~~
Method in resource controller | [table](https://laravel.com/docs/master/controllers#resource-controllers) | store | ~~saveArticle~~
Method in test class | camelCase | testGuestCannotSeeArticle | ~~test_guest_cannot_see_article~~
Variable | camelCase | $articlesWithAuthor | ~~$articles_with_author~~
Collection | descriptive, plural | $activeUsers = User::active()->get() | ~~$active, $data~~
Object | descriptive, singular | $activeUser = User::active()->first() | ~~$users, $obj~~
Config and language files index | snake_case | articles_enabled | ~~ArticlesEnabled; articles-enabled~~
View | kebab-case | show-filtered.blade.php | ~~showFiltered.blade.php, show_filtered.blade.php~~
Config | snake_case | google_calendar.php | ~~googleCalendar.php, google-calendar.php~~
Contract (interface) | adjective or noun | AuthenticationInterface | ~~Authenticatable, IAuthentication~~
Trait | adjective | Notifiable | ~~NotificationTrait~~
Trait [(PSR)](https://www.php-fig.org/bylaws/psr-naming-conventions/) | adjective | NotifiableTrait | ~~Notification~~
Enum | singular | UserType | ~~UserTypes~~, ~~UserTypeEnum~~
FormRequest | singular | UpdateUserRequest | ~~UpdateUserFormRequest~~, ~~UserFormRequest~~, ~~UserRequest~~
Seeder | singular | UserSeeder | ~~UsersSeeder~~

## Layout


# Coding Standards Guide

## 2. Brace Placement (PSR-2/PSR-12)

### Class Definitions
Place the opening brace on the same line as the class name; the closing brace should be on the next line after the body.
```php
class ClassName {
    // body
}
```

### Method Definitions
The opening brace should be on the same line as the method name; the closing brace should be on the next line after the body.
```php
public function methodName($arg1, $arg2 = '') {
    // method body
}
```

### Control Structures
The opening brace should be on the same line as the control structure keyword; the closing brace should be on its own line unless it's followed by an else or elseif.
```php
if ($x === 5) {
    echo "X is five";
} elseif ($x === 6) {
    echo "X is six";
} else {
    echo "X is neither five nor six";
}
```

## 3. Indentation and Whitespace

- Indentation: Use tabs, not spaces.
- Line Length: Try to keep lines to 80 characters; soft limit is 120 characters.
- Whitespace: Add space after control structure keywords (if, for, while, etc.), and around operators.

## 4. Naming Conventions

- Classes: StudlyCaps (PascalCase)
- Methods: camelCase
- Constants: UPPERCASE
- Properties and Variables: camelCase (Laravel tends to use snake_case for database fields)

