<template>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <jq-datatable :data-type="data_type"
                        :options="options" 
                        :elements="elements"
                        @edit-data="editData"></jq-datatable>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data_type: 'users',
                options: {
                    url: 'https://prospark-exam.test/api/users',
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
        methods: {
            editData(data) {
                var edit_modal = this.$refs.edit_modal;
                $(edit_modal).modal('show');
            }
        }
    }
</script>
