# Larasponse
Beautiful and easy to use API responses. It uses [League/Fractal](http://fractal.thephpleague.com) as a default provider.

## Installation
Add **Larasponse** to your composer.json file:

```json
"require": {
    "sorskod/larasponse": "~1.0"
}
```

and run `composer update sorskod/larasponse`

### Registering the Package

Register the service provider within the `providers` array found in `app/config/app.php`:

```php
'providers' => array(
    // ...
    'Sorskod\Larasponse\LarasponseServiceProvider'
)
```

## Usage

Here is various examples in single controller:

```php

use Sorskod\Larasponse\Larasponse;

class UserController extends BaseController
{
    protected $response;

    public function __construct(Larasponse $response)
    {
        $this->response = $response;

        // Fractal's parseIncludes are available to set here
        $this->response->parseIncludes(Input::get('includes'));
    }

    public function index()
    {
        return $this->response->paginatedCollection(User::paginate());
    }

    public function show($id)
    {
        return $this->response->item(User::find($id), new UserTransformer());
    }


    public function collection()
    {
        return $this->response->collection(User::all(), new UserTransformer(), 'users');
    }
}
```
