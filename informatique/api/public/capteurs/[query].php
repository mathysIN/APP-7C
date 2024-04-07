<?php


require_once __DIR__ . "/../../utils/helpers.php";
require_once __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/global_types.php";

$sensorId = getLastWordOfCurrentUrlPath();

$sensor = $sensorAPI->getSensorById($sensorId);

if (!$sensor) {
    redirect("/404");
    exit();
}

$volume = $sensor->getCurrentValue();
$averageVolume = $sensor->getCurrentValue();
$exceedance = $sensor->getCurrentValue();
$frequency = $sensor->getCurrentValue();

$VOLUME_THRESHOLD = 85;
$AVERAGE_VOLUME_THRESHOLD = 100;
$EXCEEDANCE_THRESHOLD = 50;
$FREQUENCY_THRESHOLD = 500;

$volumeColor = $volume > $VOLUME_THRESHOLD ? "text-red-500" : "text-black";
$averageVolumeColor = $averageVolume > $AVERAGE_VOLUME_THRESHOLD ? "text-red-500" : "text-black";
$exceedanceColor = $exceedance > $EXCEEDANCE_THRESHOLD ? "text-red-500" : "text-black";
$frequencyColor = $frequency > $FREQUENCY_THRESHOLD ? "text-red-500" : "text-black";
?>

<div class="max-w-4xl mx-auto my-8 p-6 rounded-lg">

    <a href="/mes_capteurs">
        <button class="inline-flex my-2 justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-eventit-500 hover:bg-eventit-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-eventit-500">
            Retour
        </button>
    </a>
    <div class="flex flex-col space-y-4">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold"><?php echo $sensor->name ?></h1>
                <p class="text-sm font-semibold">Devis ???</p>
                <div class="flex flex-row items-center gap-2">
                    <img src="/resources/location.png" class="w-4 h-4">
                    <p class="text-sm text-gray-500"><?php echo $sensor->location ?></p>
                </div>

            </div>
            <div class="flex space-x-2">
                <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-primary/90 h-10 px-4 py-2 bg-gray-200 text-gray-700">24h</button>
                <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-primary/90 h-10 px-4 py-2 bg-gray-200 text-gray-700">1h</button>
                <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-primary/90 h-10 px-4 py-2 bg-gray-200 text-gray-700">Live<div class="ml-2 h-2 w-2 bg-red-500 rounded-full animate-pulse"></div></button>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center">
                <p class="text-4xl font-bold <?php echo $volumeColor ?>"><?php echo $volume ?>dB</p>
                <p class="text-sm text-gray-600">Volume Actuel</p>
            </div>
            <div class="text-center">
                <p class="text-4xl font-bold <?php echo $exceedanceColor ?>"><?php echo $exceedance ?>%</p>
                <p class="text-sm text-gray-600">Dépassement moyen</p>
            </div>
            <div class="text-center">
                <p class="text-4xl font-bold <?php echo $averageVolumeColor ?>"><?php echo $averageVolume ?>dB</p>
                <p class="text-sm text-gray-600">Volume moyen</p>
            </div>
            <div class="text-center">
                <p class="text-4xl font-bold"><?php echo $frequency ?>Hz</p>
                <p class="text-sm text-gray-600">Fréquence sonore</p>
            </div>
        </div>
        <div>
            <div class="w-full">
                <div style="width: 100%; height: 100%;">
                    <div class="tooltip" id="tooltip" class="z-10"></div>

                    <div style="position: relative;">
                        <canvas id="graphCanvas" width="1000" height="500" class="w-full"></canvas>

                        <script>
                            // Create random data for the graph, with date as name and value as value
                            const data = [];
                            for (var i = 0; i < 10; i++) {
                                data.push({
                                    name: new Date(Date.now() + i * 1000 * 60 * 60).toLocaleTimeString(),
                                    value: Math.floor(Math.random() * 100)
                                });
                            }



                            // Get the canvas element and tooltip element
                            var canvas = document.getElementById("graphCanvas");
                            var tooltip = document.getElementById("tooltip");
                            var ctx = canvas.getContext("2d");

                            // Set the graph parameters
                            var graphWidth = canvas.width - 80; // Adjusted for padding
                            var graphHeight = canvas.height - 80; // Adjusted for padding
                            var maxValue = Math.max(...data.map((item) => item.value));
                            var stepSize = graphHeight / maxValue;
                            var columnWidth = graphWidth / (data.length - 1);

                            // Draw the background grid
                            ctx.beginPath();
                            ctx.strokeStyle = "#ddd"; // Grid color
                            ctx.lineWidth = 0.5;
                            // Draw vertical lines
                            for (var i = 1; i < data.length; i++) {
                                var x = 40 + i * columnWidth; // Adjusted for padding
                                ctx.moveTo(x, 40); // Adjusted for padding
                                ctx.lineTo(x, canvas.height - 40); // Adjusted for padding
                            }
                            // Draw horizontal lines
                            for (var i = 1; i <= maxValue; i += 25) {
                                var y = canvas.height - 40 - i * stepSize; // Adjusted for padding
                                ctx.moveTo(40, y); // Adjusted for padding
                                ctx.lineTo(canvas.width - 40, y); // Adjusted for padding
                            }
                            ctx.stroke();

                            // Draw the graph axes
                            ctx.beginPath();
                            ctx.moveTo(40, 40); // Adjusted for padding
                            ctx.lineTo(40, canvas.height - 40); // Adjusted for padding
                            ctx.lineTo(canvas.width - 40, canvas.height - 40); // Adjusted for padding
                            ctx.stroke();

                            // Plot the data points and fill the area under the line
                            ctx.beginPath();
                            ctx.strokeStyle = "#f04685";
                            ctx.fillStyle = "#f04685"; // Adjust the fill color and opacity as needed
                            for (var i = 0; i < data.length; i++) {
                                var x = 40 + i * columnWidth; // Adjusted for padding
                                var y = canvas.height - 40 - data[i].value * stepSize; // Adjusted for padding
                                if (i === 0) {
                                    ctx.moveTo(x, canvas.height - 40 - 0 * stepSize); // Adjusted for padding
                                } else {
                                    ctx.lineTo(x, y);
                                }
                                // ctx.arc(x, y, 3, 0, 2 * Math.PI);

                                // Draw x-axis labels
                                ctx.font = "12px Arial";
                                ctx.fillStyle = "#000";

                                ctx.textAlign = "center";
                                ctx.fillText(data[i].name, x, canvas.height - 5);
                            }
                            ctx.lineTo(40 + (data.length - 1) * columnWidth, canvas.height - 40); // Adjusted for padding
                            ctx.fillStyle = "#f04685"; // Adjust the fill color and opacity as needed

                            ctx.closePath();
                            ctx.fill();
                            ctx.stroke();

                            // Draw y-axis labels
                            ctx.beginPath();
                            ctx.font = "12px Arial";
                            ctx.fillStyle = "#000";
                            for (var i = 0; i <= maxValue; i += 25) {
                                var y = canvas.height - 40 - i * stepSize; // Adjusted for padding
                                ctx.fillText(i, 5, y);
                            }
                            ctx.closePath();
                            ctx.stroke();

                            // Draw y-axis label
                            ctx.save();
                            ctx.translate(20, canvas.height / 2); // Adjusted for padding
                            ctx.rotate(-Math.PI / 2);
                            ctx.textAlign = "center";
                            ctx.restore();

                            // Add event listener for mouse movement to display tooltips
                            // Add event listener for mouse movement to display tooltips
                            // Add event listener for mouse movement to display tooltips
                            canvas.addEventListener("mousemove", function(event) {

                                // if screen is mobile size, return
                                if (window.innerWidth < 768) {
                                    return;
                                }
                                var rect = canvas.getBoundingClientRect();
                                var scaleX = canvas.width / rect.width;
                                var scaleY = canvas.height / rect.height;
                                var mouseX = (event.clientX - rect.left) * scaleX;
                                var mouseY = (event.clientY - rect.top) * scaleY;

                                // Check if mouse is within the bounds of the graph
                                if (mouseX < 40 || mouseX > canvas.width - 40 || mouseY < 40 || mouseY > canvas.height - 40) {
                                    // If not, hide the tooltip and return
                                    tooltip.style.display = "none";
                                    return;
                                }

                                // Check if mouse is over any data point
                                for (var i = 0; i < data.length; i++) {
                                    var x = 40 + i * columnWidth;
                                    var y = canvas.height - 40 - data[i].value * stepSize; // Adjusted for padding
                                    var radius = 30; // Radius of data point circle

                                    // Calculate distance between mouse position and data point only on x-axis
                                    var distance = Math.abs(mouseX - x);

                                    if (distance <= radius) {
                                        tooltip.style.position = "absolute";
                                        tooltip.style.display = "block";
                                        tooltip.style.left = event.clientX;
                                        tooltip.style.padding = "10px";
                                        tooltip.style.backgroundColor = "#fff";
                                        tooltip.style.borderRadius = "5px";
                                        tooltip.style.boxShadow = "0 0 10px 0 rgba(0, 0, 0, 0.1)";
                                        tooltip.style.border = "1px solid #ddd";
                                        tooltip.style.top = event.clientY + window.scrollY + 10 + "px"; // Adjusted based on canvas offsetTop
                                        tooltip.innerHTML = `${data[i].value} - ${data[i].name}`;
                                        tooltip.style.zIndex = 10;
                                        return;
                                    }
                                }

                                // Hide tooltip if mouse is not over any data point
                                tooltip.style.display = "none";
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>