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

                {{-- hover info 10 records --}}
                <div class="bg-white rounded shadow-lg hover-info-temperature d-none "
                    style="position: absolute; top: 0; z-index: 25; width: 95%;">
                    <div class="p-3 d-flex justify-content-between align-items-center"
                        style="border-bottom: 1px solid rgb(168, 168, 168);">
                        <i class="bi bi-card-list text-info fw-bold fs-5" style="font-style: normal;"> Last 10
                            Records</i>
                        <i class="bi bi-x-lg fs-5" style="cursor: pointer;"></i>
                    </div>
                    <ul class="p-0 p-4" style="list-style: none;">
                        <li class="mb-2">Lorem, ipsum dolor.</li>
                        <li class="mb-2">Lorem, ipsum dolor.</li>
                        <li class="mb-2">Lorem, ipsum dolor.</li>
                        <li class="mb-2">Lorem, ipsum dolor.</li>
                        <li class="mb-2">Lorem, ipsum dolor.</li>
                    </ul>
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

                {{-- hover info 10 records --}}
                <div class="bg-white rounded shadow-lg hover-info-humidity d-none"
                    style="position: absolute; top: 0; z-index: 25; width: 95%;">
                    <div class="p-3 d-flex justify-content-between align-items-center"
                        style="border-bottom: 1px solid rgb(168, 168, 168);">
                        <i class="bi bi-card-list text-info fw-bold fs-5" style="font-style: normal;"> Last 10
                            Records</i>
                        <i class="bi bi-x-lg fs-5" style="cursor: pointer;"></i>
                    </div>
                    <ul class="p-0 p-4" style="list-style: none;">
                        <li class="mb-2">Lorem, ipsum dolor.</li>
                        <li class="mb-2">Lorem, ipsum dolor.</li>
                        <li class="mb-2">Lorem, ipsum dolor.</li>
                        <li class="mb-2">Lorem, ipsum dolor.</li>
                        <li class="mb-2">Lorem, ipsum dolor.</li>
                    </ul>
                </div>
            </div>

            {{-- amonia --}}
            <div class="col-sm-4 py-3 record-container" data-id="amonia" style="position: relative;">

                <div class="bg-white h-100 shadow-lg rounded p-3 d-flex align-items-start gap-2 amon">
                    <i class="bi bi-tropical-storm text-warning" style="font-size: 2.5rem;"></i>
                    <div class="d-grid fw-bold text-warning">
                        <h5>Current Amonia Level</h5>
                        <span class="amonia-text fs-5">Loading...</span>
                    </div>
                </div>

                {{-- hover info 10 records --}}
                <div class="bg-white rounded shadow-lg hover-info-amonia d-none"
                    style="position: absolute; top: 0; z-index: 25; width: 95%;">
                    <div class="p-3 d-flex justify-content-between align-items-center"
                        style="border-bottom: 1px solid rgb(168, 168, 168);">
                        <i class="bi bi-card-list text-info fw-bold fs-5" style="font-style: normal;"> Last 10
                            Records</i>
                        <i class="bi bi-x-lg fs-5" style="cursor: pointer;"></i>
                    </div>
                    <ul class="p-0 p-4" style="list-style: none;">
                        <li class="mb-2">Lorem, ipsum dolor.</li>
                        <li class="mb-2">Lorem, ipsum dolor.</li>
                        <li class="mb-2">Lorem, ipsum dolor.</li>
                        <li class="mb-2">Lorem, ipsum dolor.</li>
                        <li class="mb-2">Lorem, ipsum dolor.</li>
                    </ul>
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
    {{-- <button data-bs-toggle="modal" data-bs-target="#modal-last-ten-records">Show Modal</button> --}}

    {{-- modal last 10 records --}}
    <div class="modal fade" aria-hidden="true" id="modal-last-ten-records" tabindex="-1" aria-labelledby="#modal-title">
        <div class="modal-dialog modal-dialog-centered" role="dialog">
            <div class="modal-content" role="document">
                <div class="modal-header">
                    <h5 class="m-0" id="modal-title"><i class="bi bi-card-list text-primary" style="font-style: normal;"> LAST 10 RECORDS</i> </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{-- content --}}
                    <ul class="p-0 p-4" style="list-style: none;" id="ul-last-record-holder">
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
                        'X-CSRF_TOKEN' : document.querySelector('meta[name="csrf-token"]').content
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
                                                    <span>Temperature : ${element.humidity}</span>
                                                    <span>Date : ${element.date}</span>
                                                </li>`;
                        }
                        if(type == 'amonia'){
                            ul_parent.innerHTML += `<li class="mb-3 d-flex justify-content-between align-items-center">
                                                    <span>Temperature : ${element.amonia}</span>
                                                    <span>Date : ${element.date}</span>
                                                </li>`;
                        }

                    }
                    modal_records.show();
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
    </script>
</x-auth-layout>