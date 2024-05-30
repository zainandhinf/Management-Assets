function toggleDataDropdown() {
    // console.log("berhasil");
    var dataDropdown = document.getElementById('dataDropdown');
    var dataDropdown2 = document.getElementById('dataDropdown2');
    var dataDropdown4 = document.getElementById('dataDropdown4');

    // Toggle display dari <ul> ketika tautan diklik
    if (dataDropdown.style.display == 'none' && dataDropdown4.style.display == 'none') {
        dataDropdown.style.display = 'block';
    } else if (dataDropdown4.style.display == 'none') {
        dataDropdown.style.display = 'none';
        dataDropdown4.style.display = 'none';
    } else if (dataDropdown.style.display === 'block') {
        dataDropdown.style.display = 'none';
        dataDropdown4.style.display = 'block';
    } else {
        dataDropdown.style.display = 'block';
        // dataDropdown2.style.display = 'none';
        dataDropdown4.style.display = 'none';
    }
}

function toggleDataDropdown2() {
    // console.log("berhasil");
    var dataDropdown = document.getElementById('dataDropdown2');
    var dataDropdown2 = document.getElementById('dataDropdown');

    // Toggle display dari <ul> ketika tautan diklik
    if (dataDropdown.style.display === 'block') {
        dataDropdown.style.display = 'none';
    } else {
        dataDropdown.style.display = 'block';
        dataDropdown2.style.display = 'none';
    }
}

function toggleDataDropdown3() {
    // console.log("berhasil");
    var dataDropdown3 = document.getElementById('dataDropdown3');

    // Toggle display dari <ul> ketika tautan diklik
    if (dataDropdown3.style.display === 'block') {
        dataDropdown3.style.display = 'none';
    } else {
        dataDropdown3.style.display = 'block';
        // dataDropdown2.style.display = 'none';

    }
}

function toggleDataDropdown4() {
    // console.log("berhasil");
    var dataDropdown4 = document.getElementById('dataDropdown4');
    var dataDropdown = document.getElementById('dataDropdown');

    // Toggle display dari <ul> ketika tautan diklik
    // if (dataDropdown4.style.display === 'block') {
    //     dataDropdown4.style.display = 'none';
    //     dataDropdown.style.display = 'block';
    // } else if (dataDropdown.style.display == 'none') {
    //     dataDropdown4.style.display = 'none';
    // } else {
    //     dataDropdown4.style.display = 'block';
    //     dataDropdown.style.display = 'none';
    //     // dataDropdown2.style.display = 'none';

    // }
    if (dataDropdown4.style.display == 'none' && dataDropdown.style.display == 'none') {
        dataDropdown4.style.display = 'block';
    } else if (dataDropdown.style.display == 'none') {
        dataDropdown4.style.display = 'none';
        dataDropdown.style.display = 'none';
    } else if (dataDropdown4.style.display === 'block') {
        dataDropdown4.style.display = 'none';
        dataDropdown.style.display = 'block';
    } else {
        dataDropdown4.style.display = 'block';
        // dataDropdown2.style.display = 'none';
        dataDropdown.style.display = 'none';
    }
}

function toggleDataDropdown5() {
    // console.log("berhasil");
    var dataDropdown = document.getElementById('dataDropdown');
    var dataDropdown4 = document.getElementById('dataDropdown4');
    var dataDropdown5 = document.getElementById('dataDropdown5');

    // Toggle display dari <ul> ketika tautan diklik
    if (dataDropdown5.style.display == 'none' && dataDropdown.style.display == 'none' && dataDropdown4.style
        .display == 'none') {
        dataDropdown5.style.display = 'block';
    } else if (dataDropdown5.style.display == 'block' && dataDropdown.style.display == 'none' && dataDropdown4.style.display == 'none') {
        dataDropdown.style.display = 'none';
        dataDropdown4.style.display = 'none';
        dataDropdown5.style.display = 'none';
    }
    // else if (dataDropdown.style.display === 'block') {
    //     dataDropdown.style.display = 'none';
    //     dataDropdown4.style.display = 'block';
    // } 
    else {
        dataDropdown.style.display = 'block';
        // dataDropdown2.style.display = 'none';
        dataDropdown4.style.display = 'none';
    }
}

function toggleDataDropdown6() {
    // console.log("berhasil");
    var dataDropdown = document.getElementById('dataDropdown');
    var dataDropdown4 = document.getElementById('dataDropdown4');
    var dataDropdown5 = document.getElementById('dataDropdown5');
    var dataDropdown6 = document.getElementById('dataDropdown6');

    // Toggle display dari <ul> ketika tautan diklik
    if (dataDropdown6.style.display == 'none') {
        dataDropdown6.style.display = 'block';
    } else {
        dataDropdown6.style.display = 'none';
    }
}