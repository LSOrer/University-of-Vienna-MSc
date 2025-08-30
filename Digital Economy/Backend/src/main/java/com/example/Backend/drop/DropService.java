package com.example.Backend.drop;

import com.example.Backend.exception.DropNotFoundException;
import lombok.AllArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.web.bind.annotation.CrossOrigin;

import java.util.List;

@CrossOrigin
@AllArgsConstructor
@Service
public class DropService {

    private final DropRepo dropRepo;

    public List<Drop> getAllDrops() {
        return dropRepo.findAll();
    }

    public Drop saveNewDrop(Drop drop) {
        return dropRepo.insert(drop);
    }

    public Drop findDrop(String dropid) {
        for (Drop drop : dropRepo.findAll()) {
            if (drop.getDropid().equals(dropid)) {
                return drop;
            }
        }
        throw new DropNotFoundException(String.format("drop with id %s doesn't exist", dropid));
    }

    public String deleteDrop(String dropid) {
        return dropRepo.deleteByDropid(dropid);
    }

    public void deleteAll() {
        dropRepo.deleteAll();
    }
}
