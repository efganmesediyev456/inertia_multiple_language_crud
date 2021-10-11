<template>
    <app-header></app-header>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form method="post" @submit.prevent="submit">

                
                <h2 class="text-left">Create Post</h2>

                <errors-and-messages :errors="errors"></errors-and-messages>


                <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Az</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">En</button>
                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Ru</button>
                        </div>
                </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="form-group">
                                    <label for="title">Title az</label>
                                    <input type="text" class="form-control" name="title" id="title" v-model="form.title.az" />
                                </div>

                                <div class="form-group">
                                    <label for="content">Content az</label>
                                    <textarea  id="summernote_az" name="title" class="form-control summernote" v-model="form.content.az"></textarea>
                                </div>

                                
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                                <div class="form-group">
                                    <label for="title">Title En</label>
                                    <input type="text" class="form-control" name="title" id="title" v-model="form.title.en" />
                                </div>

                                <div class="form-group">
                                    <label for="content">Content En</label>
                                    <textarea id="summernote_en" name="content" class="form-control summernote" v-model="form.content.en"></textarea>
                                </div>

                             

                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

                                <div class="form-group">
                                    <label for="title">Title Ru</label>
                                    <input type="text" class="form-control" name="title" id="title" v-model="form.title.ru" />
                                </div>

                                <div class="form-group">
                                    <label for="content">Content Ru</label>
                                    <textarea id="summernote_ru" name="content" class="form-control summernote" v-model="form.content.ru"></textarea>
                                </div>

                               
                        </div>
                </div>
                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" id="image" name="image" class="form-control" @change="selectFile">
                </div>

                <input type="submit" class="btn btn-primary btn-block" value="Save" />
            </form>
        </div>
    </div>
</template>

<script>
import AppHeader from "../../Partials/AppHeader";
import ErrorsAndMessages from "../../Partials/ErrorsAndMessages";
import {inject, onMounted, reactive} from "vue";
import {Inertia} from "@inertiajs/inertia";
import {usePage} from "@inertiajs/inertia-vue3";

export default {
    name: "Create",
    components: {
        ErrorsAndMessages,
        AppHeader
    },
    props: {
        errors: Object
    },
    setup() {
        const form = reactive({
            title: {
                az:null,
                en:null,
                ru:null,
            },
            content: {
                az:null,
                en:null,
                ru:null,
            },
            image: null,
            _token: usePage().props.value.csrf_token
        });

        const route = inject('$route');

        onMounted(() => {
           $(function(){
               $("#summernote_az").summernote({
                   callbacks: {
                                onChange: function(contents, $editable) {
                                
                                form.content.az=contents
                                
                                }
                        }
               })

               $("#summernote_en").summernote({
                   callbacks: {
                                onChange: function(contents, $editable) {
                                
                                form.content.en=contents
                                
                                }
                        }
               })

               $("#summernote_ru").summernote({
                   callbacks: {
                                onChange: function(contents, $editable) {
                                
                                form.content.ru=contents
                                
                                }
                        }
               })

           })

    })
        

        function selectFile($event) {
            form.image = $event.target.files[0];
        }

        function submit() {
            Inertia.post(route('post.store'), form, {
                forceFormData: true
            });
        }

        return {
            form, submit, selectFile
        }
    }
}
</script>

<style scoped>
    form {
        margin-top: 20px;
    }
</style>