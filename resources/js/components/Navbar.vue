<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container-fluid d-print-none">
            <a class="navbar-brand" href="/home">
                Linen Inventory System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <button role="button" type="button" class="btn" data-toggle="dropdown" id="btnNotification" hidden> 
                            <span class="fa-stack fa-1x" id="counterNotification" data-count="0">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-bell fa-stack-1x fa-inverse" ></i>
                            </span>
                        </button>                            
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{userName}}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">                
                            <li><a class="dropdown-item" href="/password">Change Password</a></li>
                            <li><a class="dropdown-item" href="/area">Change Ward/Office</a></li>
                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        setup() {

        },

        props: {
            userName: String
        }
    }
</script>