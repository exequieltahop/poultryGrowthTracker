<x-auth-layout>
    <section class="container p-4">
        <div class="row">
            <div class="col-sm-4 py-3">
                <div class="bg-white h-100 shadow-lg rounded p-3 d-flex align-items-start gap-2">
                    <i class="bi bi-thermometer text-info" style="font-size: 2.5rem;"></i>
                    <div class="d-grid fw-bold text-info">
                        <h5>Current Temperature</h5>
                        <span class="temp-text fs-5">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 py-3">
                <div class="bg-white h-100 shadow-lg rounded p-3 d-flex align-items-start gap-2">
                    <i class="bi bi-moisture text-success" style="font-size: 2.5rem;"></i>
                    <div class="d-grid fw-bold text-success">
                        <h5>Current Humidity</h5>
                        <span class="humid-text fs-5">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 py-3">
                <div class="bg-white h-100 shadow-lg rounded p-3 d-flex align-items-start gap-2">
                    <i class="bi bi-tropical-storm text-warning" style="font-size: 2.5rem;"></i>
                    <div class="d-grid fw-bold text-warning">
                        <h5>Current Amonia Level</h5>
                        <span class="amonia-text fs-5">Loading...</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2" style="row-gap: 1em;">

            {{-- bulb state --}}
            <div class="col-sm-6">
                <div class="bg-white p-3 border rounded shadow d-flex flex-column align-items-center" id="bulb-state-wrapper">
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

    {{-- script --}}
    <script>
        window.addEventListener('DOMContentLoaded', ()=>{
            setInterval(() => {
                get_data();
            }, 5000);
        });

        // get data statistic
        async function get_data(){
            try {
                const response = await fetch(`${window.database_url}/records.json?auth=${encodeURIComponent(window.token)}`);

                if(!response.ok){
                    throw new Error("");
                }else{
                    const response_json = await response.json();

                    const temp = response_json.current_temperature.temperature;
                    const humidity = response_json.current_humidity.humidity;
                    const amonia = response_json.current_amonia_level.amonia;


                    const temp_text = document.querySelector('.temp-text');
                    const humid_text = document.querySelector('.humid-text');
                    const amonia_text = document.querySelector('.amonia-text');

                    temp_text.innerHTML = temp + '&deg C';
                    humid_text.textContent = humidity + '%';
                    amonia_text.textContent = amonia + 'ppm';

                    let fanOn = false;
                    let bulbOn = false;

                    if (temp > 32.0) {
                        // Very hot — turn on fan
                        fanOn = true;
                        if (humidity < 50.0) {
                            // Dry & hot — just fan
                            bulbOn = false;
                        } else {
                            // Hot & humid — fan only, no bulb
                            bulbOn = false;
                        }
                    } else if (temp >= 28.0 && temp <= 32.0) {
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
                    } else if (temp < 28.0) {
                        if (humidity < 45.0 && amonia < 5.0) {
                            // Cold & dry — turn on bulb
                            fanOn = false;
                            bulbOn = true;
                        } else if (humidity > 65.0 || ammonia > 15.0) {
                            // Cold but bad air quality — fan & bulb both
                            fanOn = true;
                            bulbOn = true;
                        } else {
                            // Cold but tolerable
                            fanOn = false;
                            bulbOn = false;
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

                    // Output the result
                    console.log("Fan is " + (fanOn ? "ON" : "OFF"));
                    console.log("Bulb is " + (bulbOn ? "ON" : "OFF"));
                }
            } catch (error) {
                console.error(error);
                toastr.error("Failed to get data for current temp, humidity, amonia level, If the problem persist contact developer!, Thank you", "Error");
            }
        }
    </script>
</x-auth-layout>