<template>

    <header >
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="min-height:10vh">
  <div class="container-fluid">
     <inertia-link :href="$route('post.index')" class="navbar-brand">Inertia CRUD</inertia-link>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
         <li class="nav-item active">
                        <inertia-link :href="$route('post.index')" class="nav-link">Home</inertia-link>
                    </li>
                    <li class="nav-item">
                        <inertia-link :href="$route('post.create')" class="nav-link">Create Post</inertia-link>
        </li>
      </ul>
      <div class="d-flex">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item" v-if="!user">
                        <inertia-link :href="$route('showLoginForm')" class="nav-link">Login</inertia-link>
                    </li>
                    <li class="nav-item" v-if="!user">
                        <inertia-link :href="$route('showRegisterForm')" class="nav-link">Register</inertia-link>
                    </li>
                    <li class="nav-item" v-if="user">
                        <span class="navbar-text" v-if="user">
                            Logged in as {{user.name}}
                        </span>
                        <inertia-link :href="$route('logout')" as="button" method="post" class="nav-link logout-link" style="display: inline" type="button">Logout</inertia-link>
                    </li>
          </ul>
      </div>
    </div>
  </div>
</nav>
       
    </header>

   
</template>

<script>
import {computed} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";

export default {
    name: "AppHeader",
    setup() {
        const user = computed(() => usePage().props.value.auth.user);

        return {
            user
        }
    }
}
</script>