<x-auth-layout>
    <section class="container">
        {{-- <h1>{{__("Welcome user ". session('email'))}}</h1> --}}

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
                }
            } catch (error) {
                console.error(error);
                toastr.error("Failed to get data for current temp, humidity, amonia level, If the problem persist contact developer!, Thank you", "Error");
            }
        }
    </script>
</x-auth-layout>