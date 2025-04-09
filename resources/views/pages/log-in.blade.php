<x-guest-layout title="Log in">
    <section class="container d-grid vh-100" style="place-items: center;">
        <form action="" class="w-100 border shadow-lg p-4" style="max-width: 500px;">
            <div class="input-group mb-3">
                <label for="email" class="input-group-text">
                    <i class="bi bi-person-fill"></i>
                </label>
                <input type="email" name="email" id="email" class="form-control" required autocomplete="email">
            </div>
            <div class="input-group mb-3">
                <label for="password" class="input-group-text">
                    <i class="bi bi-key"></i>
                </label>
                <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password">
            </div>
            <div class="d-flex justify-content-end align-items-center gap-2">
                <a href="" class="btn btn-primary">Sign up</a>
                <button class="btn btn-primary" type="submit">Sign in</button>
            </div>
        </form>
    </section>
</x-guest-layout>