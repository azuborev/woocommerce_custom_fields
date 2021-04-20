(function (document) {
    var container = document.querySelector('#svgPlaceholder');

    if (container) {
    
        container.innerHTML = "<svg xmlns=\"http://www.w3.org/2000/svg\"><symbol viewBox=\"0 0 60 60\" id=\"facebook\"><title>facebook</title> <path d=\"M36.6,30H32v15h-6V30h-3v-5h3v-3.7c0-0.6,0.2-1.3,0.4-2c0.2-0.7,0.5-1.4,1-2s1.1-1.2,2-1.6c0.8-0.4,1.9-0.7,3.2-0.7H37v5\r\n\th-3.2c-0.3,0-0.8,0.2-1.1,0.4c-0.3,0.2-0.7,0.7-0.7,1.3V25h5.2L36.6,30z\"/> </symbol><symbol viewBox=\"0 0 60 60\" id=\"twitter\"><title>twitter</title> <path d=\"M43.6,23.8c-0.5,0.5-1.1,1-1.8,1.4c0.1,0.2,0.1,0.5,0.1,0.8c0,2-0.4,4.1-1.2,6.2c-0.8,2.1-1.9,4-3.4,5.7\r\n\tC35.9,39.6,34,41,31.9,42s-4.7,1.6-7.5,1.6c-1.7,0-3.4-0.2-5-0.7c-1.6-0.5-3.1-1.2-4.4-2c0.3,0.1,0.8,0.1,1.5,0.1\r\n\tc2.9,0,5.4-0.9,7.7-2.6c-1.4-0.1-2.6-0.5-3.6-1.3c-1-0.8-1.8-1.9-2.2-3.1c0.2,0.1,0.4,0,0.6,0h0.6h0.8c0.2,0,0.5,0,0.8-0.1\r\n\tc-1.4-0.3-2.7-1-3.6-2.1c-1-1.1-1.5-2.4-1.5-3.8v-0.1c1,0.5,1.9,0.7,2.8,0.7c-0.9-0.6-1.5-1.3-2-2.2c-0.5-0.9-0.7-1.9-0.7-3\r\n\tc0-1,0.3-2,0.9-3c1.5,1.8,3.4,3.4,5.5,4.5c2.2,1.2,4.5,1.8,7.1,1.9c-0.1-0.3-0.1-0.8-0.1-1.5c0-1.7,0.6-3.2,1.8-4.3\r\n\tc1.2-1.2,2.7-1.8,4.4-1.8c1.8,0,3.3,0.6,4.4,1.9c1.4-0.2,2.7-0.8,4-1.6c-0.5,1.5-1.4,2.6-2.8,3.4c0.7-0.1,1.3-0.2,1.9-0.3\r\n\tc0.6-0.2,1.2-0.4,1.7-0.6C44.6,22.7,44.1,23.3,43.6,23.8z\"/> </symbol><symbol viewBox=\"0 0 60 60\" id=\"youtube\"><title>youtube</title> <path d=\"M43.7,31.7L22.8,45.8c-0.9,0.6-1.7,0.6-2.5,0.2c-0.8-0.4-1.2-1.1-1.2-2.2v-1.7v-22v-4.1c0-1,0.4-1.8,1.2-2.2\r\n\tc0.8-0.4,1.6-0.4,2.5,0.1l20.9,13.8c0.9,0.6,1.3,1.2,1.3,1.9S44.5,31.2,43.7,31.7z\"/> </symbol></svg>";

    

    } else {
        throw new Error('svginjector: Could not find element: #svgPlaceholder');
    }

})(document);
