<template>
    <div>
        <navbar :user-name="userName"></navbar>
        <Menu></Menu>

        <div class="container-fluid">
            <h1>
                {{userName}}
            </h1>
        </div>
    </div>
</template>

<script>
    import Navbar from './Navbar'
    import Menu from './Menu'

    export default {
        setup () {
            return {}
        },

        components: {
            Navbar, Menu
        },

        props: {
            userName: String
        }
    }
</script>