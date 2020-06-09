<template>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <jq-datatable :options="options" :elements="elements"></jq-datatable>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                options: {
                    url: 'api/users',
                    data_src: 'users',
                    columns: [
                        {data: 'name'},
                        {data: 'email'},
                        {data: 'email_verified_at'},
                        {data: 'created_at'}
                    ]
                },
                elements: {
                    theaders: ['Name', 'Email', 'Email Verified', 'Created At'],
                }
            }
        },
    }
</script>
