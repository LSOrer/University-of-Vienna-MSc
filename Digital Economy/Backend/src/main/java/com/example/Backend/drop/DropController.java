package com.example.Backend.drop;

import lombok.AllArgsConstructor;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@CrossOrigin
@RestController
@RequestMapping("api/drops")
@AllArgsConstructor
public class DropController {

    private final DropService dropService;

    @GetMapping
    public List<Drop> fetchAllDrops() {
        return dropService.getAllDrops();
    }

    @PostMapping(consumes = "application/json", produces = "application/json")
    @ResponseBody
    public Drop addDrop(@RequestBody Drop drop) {
        return dropService.saveNewDrop(drop);
    }

    @GetMapping(value = "/{dropid}")
    @ResponseBody
    public Drop fetchDropWithId(@PathVariable String dropid) {
        return dropService.findDrop(dropid);
    }

    @DeleteMapping(path = "/{dropid}")
    public String deleteDrop(@PathVariable String dropid) {
        return dropService.deleteDrop(dropid);
    }

    @DeleteMapping(path = "/all")
    public String deleteAllDrops() {
        dropService.deleteAll();
        return "Success";
    }
}
