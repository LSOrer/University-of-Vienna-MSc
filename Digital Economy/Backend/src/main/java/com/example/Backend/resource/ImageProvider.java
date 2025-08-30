package com.example.Backend.resource;

import lombok.AllArgsConstructor;
import org.springframework.core.io.ByteArrayResource;
import org.springframework.core.io.Resource;
import org.springframework.http.HttpStatus;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.io.File;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.ArrayList;
import java.util.List;

@CrossOrigin
@RestController
@RequestMapping("api/images")
@AllArgsConstructor
public class ImageProvider {

    @GetMapping(value = "/{imagename}", produces = MediaType.IMAGE_JPEG_VALUE)
    public ResponseEntity<Resource> image(@PathVariable String imagename) throws IOException {
        final ByteArrayResource inputStream = new ByteArrayResource(Files.readAllBytes(Paths.get(
                "src/main/resources/images/" + imagename
        )));
        return ResponseEntity
                .status(HttpStatus.OK)
                .contentLength(inputStream.contentLength())
                .body(inputStream);
    }

    @GetMapping(path = "/available")
    @ResponseBody
    public List<String> fetchAllImages() {
        List<String> images = new ArrayList<>();
        for (File file : new File("src/main/resources/images").listFiles()) {
            if (!file.getName().equals(".DS_Store")) {
                images.add(file.getName());
            }
        }
        return images;
    }

}
