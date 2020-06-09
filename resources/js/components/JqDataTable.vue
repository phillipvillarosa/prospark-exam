<template>
	<table ref="datatable" id="datatable" class="table table-striped" style="width:100%">
		<thead>
			<tr>
				<th v-for="theader in elements.theaders">{{theader}}</th>
			</tr>
		</thead>
	</table>
</template>

<script>
	export default {
		props: ['options', 'elements', 'dataType'],
		data() {
			return {
				dt: {},
				user_data: {},
			}
		},
		mounted() {
			var table = this.dt = $(this.$refs.datatable).DataTable({
				serverSide: true,
				ajax: {
					url: this.options.url,
					dataSrc: this.options.data_src,
				},
				columns: this.options.columns,
				processing: true,
				dom: '<f<t>p>',
				select: {
					toggleable: true
				},
				"fnDrawCallback": function(oSettings) {
					if ($('#datatable tr').length < 11) {
						$('.dataTables_paginate').hide();
					} else {
						$('.dataTables_paginate').show();
					}
				}
				// buttons: [
				//     {
				//         text: 'Edit',
				//         action: () => {
				//         	var data = table.rows( { selected: true } ).data();
				//         	if (data) {
				//         		this.$emit('edit-data', data[0]);
				//         	}
				//         }
				//     },
				//     {
				//         text: 'Delete',
				//         action: () => {
				//         	var data = table.rows( { selected: true } ).data();
				//         	if (data) {
				//         		this.$emit('delete-data', data[0]);
				//         	}
				//         }
				//     },
				// ]
			});


		},
	}
</script>
