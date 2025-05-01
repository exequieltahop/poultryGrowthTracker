<x-auth-layout>

    {{-- dashboard data --}}
    <section class="container p-4">
        <div class="row">

            {{-- temperature --}}
            <div class="col-sm-4 py-3 record-container" data-id="temperature" style="position: relative;">
                <div class="bg-white h-100 shadow-lg rounded p-3 d-flex align-items-start gap-2 temp">
                    <i class="bi bi-thermometer text-info" style="font-size: 2.5rem;"></i>
                    <div class="d-grid fw-bold text-info">
                        <h5>Current Temperature</h5>
                        <span class="temp-text fs-5">Loading...</span>
                    </div>
                </div>
            </div>

            {{-- humidity --}}
            <div class="col-sm-4 py-3 record-container" data-id="humidity" style="position: relative;">
                <div class="bg-white h-100 shadow-lg rounded p-3 d-flex align-items-start gap-2 humi">
                    <i class="bi bi-moisture text-success" style="font-size: 2.5rem;"></i>
                    <div class="d-grid fw-bold text-success">
                        <h5>Current Humidity</h5>
                        <span class="humid-text fs-5">Loading...</span>
                    </div>
                </div>
            </div>

            {{-- ammonia --}}
            <div class="col-sm-4 py-3 record-container" data-id="amonia" style="position: relative;">
                <div class="bg-white h-100 shadow-lg rounded p-3 d-flex align-items-start gap-2 amon">
                    <i class="bi bi-tropical-storm text-warning" style="font-size: 2.5rem;"></i>
                    <div class="d-grid fw-bold text-warning">
                        <h5>Current Ammonia Level</h5>
                        <span class="amonia-text fs-5">Loading...</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- fan and bulb --}}
        <div class="row mt-2" style="row-gap: 1em;">

            {{-- bulb state --}}
            <div class="col-sm-6">
                <div class="bg-white p-3 border rounded shadow d-flex flex-column align-items-center"
                    id="bulb-state-wrapper">
                </div>
            </div>

            {{-- fan state --}}
            <div class="col-sm-6">
                <div class="bg-white p-3 border rounded shadow d-flex flex-column align-items-center"
                    id="fan-state-container">

                </div>
            </div>

        </div>
    </section>

    {{-- modal last 10 records --}}
    <div class="modal fade" aria-hidden="true" id="modal-last-ten-records" tabindex="-1" aria-labelledby="#modal-title">
        <div class="modal-dialog modal-dialog-centered" role="dialog">
            <div class="modal-content" role="document">
                <div class="modal-header">
                    <h5 class="m-0" id="modal-title"><i class="bi bi-card-list text-primary"
                            style="font-style: normal;"> LAST 10 RECORDS</i> </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{-- filter input --}}
                    <form action="" id="form-filter-date"
                        class="d-flex justify-content-between align-items-center mb-2 gap-2">
                        <input type="date" class="form-control border" name="date" id="date">
                        <button type="submit" class="btn btn-primary" style="height: fit-content; text-wrap: nowrap;">
                            <i class="bi bi-filter" style="font-style: normal;"> Filter</i>
                        </button>
                    </form>
                    <hr>
                    {{-- content --}}
                    <ul class="p-0 p-4" style="list-style: none; max-height: 60vh; overflow: auto;"
                        id="ul-last-record-holder">
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- script --}}
    <script>
        window.addEventListener('DOMContentLoaded', ()=>{
            get_data();
            setInterval(() => {
                get_data();
            }, 5000);

            // init hover to view 10 last record of temperature
            hoverTempContainer();

        });

        // get data statistic
        async function get_data(){
            try {
                const url = `/get-sensor-current-data`;
                const response = await fetch(url, {
                    method : 'GET',
                    headers : {
                        'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if(!response.ok){
                    throw new Error("");
                }else{
                    const response_json = await response.json();

                    // get data from server
                    const temp = Number(Number(response_json.temperature).toFixed(2));
                    const humidity = Number(Number(response_json.humidity).toFixed(2));
                    const amonia = Number(Number(response_json.amonia).toFixed(2));


                    // get the temperature,humidity,and amonia text container
                    const temp_text = document.querySelector('.temp-text');
                    const humid_text = document.querySelector('.humid-text');
                    const amonia_text = document.querySelector('.amonia-text');

                    temp_text.innerHTML = temp + '&deg C';
                    humid_text.textContent = humidity + '%';
                    amonia_text.textContent = amonia + 'ppm';

                    let fanOn = false;
                    let bulbOn = false;

                    if (temp > 35.0) {
                        // Very hot — turn on fan
                        fanOn = true;
                        if (humidity < 50.0) {
                            // Dry & hot — just fan
                            bulbOn = false;
                        } else {
                            // Hot & humid — fan only, no bulb
                            bulbOn = false;
                        }
                    } else if (temp >= 33.0 && temp <= 35.0) {
                        if (humidity >= 45.0 && humidity <= 65.0 && amonia >= 5.0 && amonia <= 15.0) {
                            // Comfortable zone — no fan, no bulb
                            fanOn = false;
                            bulbOn = false;
                        } else if (amonia > 15.0) {
                            // Dangerous amonia
                            fanOn = true;
                            bulbOn = false;
                        } else {
                            // Slight adjustments
                            fanOn = false;
                            bulbOn = false;
                        }
                    } else if (temp < 33.0) {
                        if (humidity < 45.0 && amonia < 5.0) {
                            // Cold & dry — turn on bulb
                            fanOn = false;
                            bulbOn = true;
                        } else if (humidity > 65.0 || amonia > 15.0) {
                            // Cold but bad air quality — fan & bulb both
                            fanOn = true;
                            bulbOn = true;
                        } else if(humidity < 45.0 && (amonia > 5 && amonia < 15)){
                            // Cold but tolerable
                            fanOn = false;
                            bulbOn = true;
                        }
                    }

                    const fan_wrapper = document.getElementById('fan-state-container');
                    const bulb_wrapper = document.getElementById('bulb-state-wrapper');

                    if(fanOn == true){
                        fan_wrapper.innerHTML = `<i class="bi bi-fan text-success" style="font-size: 5rem;"></i>
                                                <h1 class="text-success">Fan On</h1>`;
                    }else{

                        fan_wrapper.innerHTML = `<i class="bi bi-fan text-secondary" style="font-size: 5rem;"></i>
                                                <h1 class="text-secondary">Fan Off</h1>`;

                                            }
                    if(bulbOn == true){
                        bulb_wrapper.innerHTML = `<i class="bi bi-lightbulb-fill text-warning" style="font-size: 5rem;"></i>
                                                <h1 class="text-warning">Bulb On</h1>`;
                    }else{

                        bulb_wrapper.innerHTML = `<i class="bi bi-lightbulb-fill text-secondary" style="font-size: 5rem;"></i>
                                                <h1 class="text-secondary">Bulb Off</h1>`;
                    }

                }
            } catch (error) {
                console.error(error);
                toastr.error("Failed to get data for current temp, humidity, amonia level, If the problem persist contact developer!, Thank you", "Error");
            }
        }
        // hover temp
        function hoverTempContainer(){
            const temp_container = document.querySelectorAll('.record-container');
            // const record_wrapper = document.querySelector('.record-wrapper');

            Array.from(temp_container).forEach(item => {
                item.onclick = async (e)=>{
                    e.stopImmediatePropagation();
                    e.preventDefault();

                    const type = e.currentTarget.dataset.id;

                    const data = await tenlogs(type);

                    const modal_records = new bootstrap.Modal(document.getElementById('modal-last-ten-records'));
                    const ul_parent = document.getElementById('ul-last-record-holder');

                    ul_parent.innerHTML = ``;


                    for (const element of data) {
                        if(type == 'temperature'){
                            ul_parent.innerHTML += `<li class="mb-3 d-flex justify-content-between align-items-center">
                                                    <span>Temperature : ${element.temperature}</span>
                                                    <span>Date : ${element.date}</span>
                                                </li>`;
                        }
                        if(type == 'humidity'){
                            ul_parent.innerHTML += `<li class="mb-3 d-flex justify-content-between align-items-center">
                                                    <span>Humidity : ${element.humidity}</span>
                                                    <span>Date : ${element.date}</span>
                                                </li>`;
                        }
                        if(type == 'amonia'){
                            ul_parent.innerHTML += `<li class="mb-3 d-flex justify-content-between align-items-center">
                                                    <span>Ammonia : ${element.amonia}</span>
                                                    <span>Date : ${element.date}</span>
                                                </li>`;
                        }

                    }

                    modal_records.show();

                    filterLogs(document.getElementById('form-filter-date'), type, ul_parent);
                };
            });
        }

        // hover for 10 current last readings
        async function tenlogs(type){
            try {
                const url = `/get-ten-records/${type}`;

                const response = await fetch(url,{
                        method : 'GET',
                        headers : {
                            'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                if(!response.ok){
                    throw new Error("");
                }else{
                    return await response.json();
                }
            } catch (error) {
                throw error;
            }
        }

        // filter log
        async function filterLogs(form, type, ul_parent) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                try {
                    /**
                     * prepare url
                     * prepare get response
                    */
                   const formData = new FormData(e.target);

                   formData.append('type', type);

                    const url = `/filter-logs`;
                    const response = await fetch(url, {
                        method : 'POST',
                        headers : {
                            'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content
                        },
                        body : formData
                    });

                    /**
                     * if response was not ok
                     * then throw new Error
                    */
                    if(!response){
                        throw new Error("");
                    }else{
                        /**
                         * else process response logs
                         * with the filtered date
                        */
                        const data = await response.json();

                        ul_parent.innerHTML = ``;

                        for (const element of data) {
                            if(type == 'temperature'){
                                ul_parent.innerHTML += `<li class="mb-3 d-flex justify-content-between align-items-center">
                                                        <span>Temperature : ${element.temperature}</span>
                                                        <span>Date : ${element.date}</span>
                                                    </li>`;
                            }
                            if(type == 'humidity'){
                                ul_parent.innerHTML += `<li class="mb-3 d-flex justify-content-between align-items-center">
                                                        <span>Humidity : ${element.humidity}</span>
                                                        <span>Date : ${element.date}</span>
                                                    </li>`;
                            }
                            if(type == 'amonia'){
                                ul_parent.innerHTML += `<li class="mb-3 d-flex justify-content-between align-items-center">
                                                        <span>Ammonia : ${element.amonia}</span>
                                                        <span>Date : ${element.date}</span>
                                                    </li>`;
                            }

                        }
                    }
                } catch (error) {
                    /**
                     * log errors
                     * show error toastr
                     */
                    console.error(error.message);
                    toastr.error("Something went wrong, Pls try again, If the problem persist, Pls Contact Developer", "Error");
                }
            });
        }
    </script>
</x-auth-layout>