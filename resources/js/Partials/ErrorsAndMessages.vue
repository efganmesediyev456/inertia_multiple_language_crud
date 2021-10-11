<template>
    <ul class="alert alert-danger" v-if="errors && Object.keys(errors).length > 0">
        <li v-for="error in errors">{{error}}</li>
    </ul>
    <div class="alert alert-success" v-if="$page.props.flash.success">
        {{$page.props.flash.success}}
    </div>
</template>

<script>
export default {
    name: "ErrorsAndMessages",
    props: ["errors"]
}
</script>