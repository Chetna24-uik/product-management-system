function drawChart(labels, values) {
    new Chart(document.getElementById("barChart"), {
        type: "bar",
        data: {
            labels: labels,
            datasets: [{
                label: "Products per Category",
                data: values
            }]
        }
    });
}
