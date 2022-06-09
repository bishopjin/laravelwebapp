<template>
    <div class="d-flex justify-content-center">
        <div class="">
            &copy; {{ currentDate }} &nbsp;
            <a :href="urls" class="text-secondary" target="__blank">Gene Sedan</a>
        </div>
    </div>

</template>

<script>
    export default {
        name : "Footer",
        props : [
            'currentDate',
            'urls'
        ]
    }
</script>
