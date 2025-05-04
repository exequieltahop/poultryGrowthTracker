document.addEventListener('DOMContentLoaded', () => {
    // init data table
    const logs_table = new DataTable('#table-data-logs', {
        responsive: true
    });

    // initDataTable();
});

// get data
async function initDataTable() {
    try {
        const url = `/get-table-data-logs`; // api endpoint

        /**
         * get request via fetch api
         * with
         * headers
         * method
         */
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        // if response was not ok then throw new error
        if (!response.ok) {
            throw new Error("");
        } else {
            // else process data then display data of the datatable
            const response_json = await response.json();

            console.log(response_json);

            const logs_table = new DataTable('#table-data-logs', {
                responsive: true
            });
        }
    } catch (error) {
        /**
         * log errors
         * show error toast
         */
        console.error(error.message);
        toastr.error("Something Went Wrong!, Pls Try Again", "Error");
    }
}