---
layout: center
---

<v-clicks>

# Is Laravel a full-stack framework?

# No

# But also yes

# (x3)

</v-clicks>

---

# Blade <small>(server-side rendering)</small>

```php [routes/web.php]
Route::get("/greeting", function () {
    $user = App\Models\User::all();
    return view("greeting", ["users" => $users]);
});
```

```blade [resources/views/greeting.blade.php]
<div>
    @foreach ($users as $user)
        Hello, {{ $user->name }} <br />
    @endforeach
</div>
```

---

# Inertia <small>(client-side rendering)</small>

```php [routes/web.php]
Route::get("/user", function () {
    $user = User::findOrFail($id);
    return Inertia::render("users/show", [
        "user" => $user,
    ]);
});
```

<v-switch>

<template #0>

```tsx [resources/js/Pages/users/show.tsx]
import Layout from "@/layouts/authenticated";
import { Head } from "@inertiajs/react";

export default function Show({ user }) {
    return (
        <Layout>
            <Head title="Welcome" />
            <h1>Welcome</h1>
            <p>Hello {user.name}, welcome to Inertia.</p>
        </Layout>
    );
}
```

</template>

<template #1>

```vue [resources/js/Pages/users/show.vue]
<script setup>
import Layout from "@/layouts/authenticated.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Layout>
        <Head title="Welcome" />
        <h1>Welcome</h1>
        <p>Hello {{ user.name }}, welcome to Inertia.</p>
    </Layout>
</template>
```

</template>

<template #2>

It also does server-side pre-rendering, but needs Node.js for that, and a more complex setup.

</template>

</v-switch>

---

# Livewire <small>(server-side rendering with interactivity)</small>

<!-- prettier-ignore -->
<<< ../app/Livewire/Projects/Contents.php#component {*|7|17-20|9-15|22-25}{lines:true,maxHeight:'90%'}

---

# Livewire <small>(server-side rendering with interactivity)</small>

<!-- prettier-ignore -->
<<< ../resources/views/livewire/projects/contents.blade.php {*|37-41|17-21}{lines:true,maxHeight:'90%'}

---

# Livewire <small>(server-side rendering with interactivity)</small>

<!-- prettier-ignore -->
<<< ../app/Livewire/Projects/Contents.php#component {27-35|33}{lines:true,maxHeight:'90%'}

---

# Livewire <small>(server-side rendering with interactivity)</small>

<!-- prettier-ignore -->
<<< ../resources/views/livewire/projects/contents.blade.php {36}{lines:true,maxHeight:'90%'}

---
layout: fact
---

In ye olden times, we used to have a name for this

<v-click>

# React Server Components

</v-click>

<v-click>

But apparently the world is not ready for that yet.

</v-click>
