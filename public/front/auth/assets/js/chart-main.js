// Chart Configuration and Data
const chartConfig = {
    visitChart: {
        monthly: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            data: [25, 20, 35, 45, 55, 60, 65, 70, 75, 65, 60, 55]
        },
        weekly: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            data: [40, 55, 70, 65]
        },
        daily: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            data: [30, 45, 60, 55, 70, 80, 65]
        }
    },
    earningsChart: {
        horses: { percentage: 45, color: '#4CAF50' },
        equipment: { percentage: 30, color: '#FF9800' },
        services: { percentage: 25, color: '#4A90E2' }
    }
};

// Chart Instances
let visitChartInstance = null;

// Initialize Charts
document.addEventListener('DOMContentLoaded', function() {
    initializeVisitChart();
    initializeEarningsChart();
    addEarningsChartInteractivity();
});

// Visit Chart Initialization
function initializeVisitChart() {
    const ctx = document.getElementById('visitChart').getContext('2d');
    const data = chartConfig.visitChart.monthly;
    
    visitChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Visits',
                data: data.data,
                borderColor: '#D2691E',
                backgroundColor: createGradient(ctx, '#4A90E2', '#E3F2FD'),
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#4A90E2',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#4A90E2',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#4A90E2',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        title: function(context) {
                            return `${context[0].label}`;
                        },
                        label: function(context) {
                            return `Visits: ${context.parsed.y}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        color: '#666666',
                        font: {
                            size: 12
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: '#f0f0f0',
                        drawBorder: false
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        color: '#666666',
                        font: {
                            size: 12
                        },
                        stepSize: 20
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    });
}

// Earnings Chart Initialization (Custom Radial Chart)
function initializeEarningsChart() {
    const segments = document.querySelectorAll('.chart-segment');
    
    // Calculate stroke-dasharray and stroke-dashoffset for each segment
    const outerRadius = 85;
    const middleRadius = 65;
    const innerRadius = 45;
    
    const outerCircumference = 2 * Math.PI * outerRadius;
    const middleCircumference = 2 * Math.PI * middleRadius;
    const innerCircumference = 2 * Math.PI * innerRadius;
    
    // Services & Jobs (Blue) - Outer ring - 70% of circle
    const outerSegment = segments[0];
    const outerDashArray = outerCircumference * 0.7;
    const outerGap = outerCircumference - outerDashArray;
    outerSegment.setAttribute('stroke-dasharray', `${outerDashArray} ${outerGap}`);
    outerSegment.setAttribute('stroke-dashoffset', outerCircumference * 0.15);
    
    // Equipment & Apparel (Orange) - Middle ring - 60% of circle
    const middleSegment = segments[1];
    const middleDashArray = middleCircumference * 0.6;
    const middleGap = middleCircumference - middleDashArray;
    middleSegment.setAttribute('stroke-dasharray', `${middleDashArray} ${middleGap}`);
    middleSegment.setAttribute('stroke-dashoffset', middleCircumference * 0.15);
    
    // Horses (Green) - Inner ring - 80% of circle
    const innerSegment = segments[2];
    const innerDashArray = innerCircumference * 0.8;
    const innerGap = innerCircumference - innerDashArray;
    innerSegment.setAttribute('stroke-dasharray', `${innerDashArray} ${innerGap}`);
    innerSegment.setAttribute('stroke-dashoffset', innerCircumference * 0.1);
}

// Add Interactivity to Earnings Chart
function addEarningsChartInteractivity() {
    const segments = document.querySelectorAll('.chart-segment');
    const legendItems = document.querySelectorAll('.legend-item');
    
    // Add click events to legend items
    legendItems.forEach((item, index) => {
        item.style.cursor = 'pointer';
        item.addEventListener('click', function() {
            // Toggle segment visibility
            const segment = segments[index];
            const isHidden = segment.style.opacity === '0.3';
            
            if (isHidden) {
                segment.style.opacity = '1';
                item.style.opacity = '1';
            } else {
                segment.style.opacity = '0.3';
                item.style.opacity = '0.5';
            }
        });
        
        // Add hover effects
        item.addEventListener('mouseenter', function() {
            segments[index].style.filter = 'brightness(1.2) drop-shadow(0 0 10px rgba(0, 0, 0, 0.3))';
        });
        
        item.addEventListener('mouseleave', function() {
            segments[index].style.filter = 'none';
        });
    });
    
    // Add hover effects to segments
    segments.forEach((segment, index) => {
        segment.addEventListener('mouseenter', function() {
            legendItems[index].style.transform = 'translateX(5px)';
            legendItems[index].style.transition = 'transform 0.2s ease';
        });
        
        segment.addEventListener('mouseleave', function() {
            legendItems[index].style.transform = 'translateX(0)';
        });
    });
}

// Update Visit Chart Function
function updateVisitChart(period) {
    if (!visitChartInstance) return;
    
    const data = chartConfig.visitChart[period];
    if (!data) return;
    
    // Add loading state
    const chartContainer = document.querySelector('#visitChart').parentElement;
    chartContainer.classList.add('chart-loading');
    
    setTimeout(() => {
        visitChartInstance.data.labels = data.labels;
        visitChartInstance.data.datasets[0].data = data.data;
        visitChartInstance.update('active');
        
        // Remove loading state
        chartContainer.classList.remove('chart-loading');
        
        // Update dropdown text
        const dropdownButton = document.querySelector('.dropdown-toggle');
        dropdownButton.textContent = period.charAt(0).toUpperCase() + period.slice(1);
    }, 300);
}

// Create Gradient Helper Function
function createGradient(ctx, color1, color2) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, color1 + '40');
    gradient.addColorStop(1, color2 + '10');
    return gradient;
}

// Responsive Chart Resize Handler
window.addEventListener('resize', function() {
    if (visitChartInstance) {
        visitChartInstance.resize();
    }
});

// Chart Animation on Scroll
function animateChartsOnScroll() {
    const charts = document.querySelectorAll('.chart-card');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });
    
    charts.forEach(chart => {
        chart.style.opacity = '0';
        chart.style.transform = 'translateY(20px)';
        chart.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(chart);
    });
}

// Initialize scroll animations
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(animateChartsOnScroll, 100);
});

// Export functions for external use
window.ChartManager = {
    updateVisitChart,
    visitChartInstance: () => visitChartInstance
};