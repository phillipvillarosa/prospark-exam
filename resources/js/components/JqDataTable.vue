<template>
	<table ref="datatable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
            	<th v-for="theader in elements.theaders">{{theader}}</th>
            </tr>
        </thead>
    </table>
</template>

<script>
    export default {
    	props: ['options', 'elements'],
        data() {
            return {
                dt: {},
                user_data: {}
            }
        },
        mounted() {
            this.dt = $(this.$refs.datatable).DataTable({
            	serverSide: true,
                ajax: {
                    url: this.options.url,
                    dataSrc: this.options.data_src,
                },
                columns: this.options.columns,
                dom: 'Bfrtp',
			    select: true,
			    buttons: [
		            {
		                text: 'Select all',
		                action: function () {
		                    table.rows().select();
		                }
		            },
		            {
		                text: 'Select none',
		                action: function () {
		                    table.rows().deselect();
		                }
		            }
		        ]
            });


        },
    }
</script>
