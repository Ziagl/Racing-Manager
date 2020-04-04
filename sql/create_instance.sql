--instance
INSERT INTO instance (id, name, state, phpbb_forum_id_de, phpbb_forum_id_en, current_race, current_day, season) VALUES (2, 0, 0, "Pole Position", 0, 1, 1, 1);
--driver
INSERT INTO driver (ins_id, firstname, lastname, shortname, gender, cou_id, speed, persistence, experience, stamina, freshness, morale, birthday, picture, wage, bonus)
SELECT 2 as ins_id, firstname, lastname, shortname, gender, cou_id, speed, persistence, experience, stamina, freshness, morale, birthday, picture, wage, bonus FROM driver WHERE ins_id = 1;
--team
INSERT INTO team (ins_id, name, manager, location, picture, value, cou_id, color1, color2, class, league)
SELECT 2 as ins_id, name, manager, location, picture, value, cou_id, color1, color2, class, league FROM team WHERE ins_id = 1;
--track
INSERT INTO track (ins_id, name, cou_id, distance, rounds, curves, dsgcurves, dsgstraights, fuel_consumption, overtake_propability, weather, picture, pit_stop, body, brakes, engine, aerodynamics, electronics, suspension, gearbox, hydraulics, kers, drs, tire)
SELECT 2 as ins_id, name, cou_id, distance, rounds, curves, dsgcurves, dsgstraights, fuel_consumption, overtake_propability, weather, picture, pit_stop, body, brakes, engine, aerodynamics, electronics, suspension, gearbox, hydraulics, kers, drs, tire FROM track WHERE ins_id = 1;
--track_calendar
INSERT INTO track_calendar (ins_id, tra_id, rank, training_date, qualification_date, race_date)
SELECT 2 as ins_id, tra_id, rank, training_date, qualification_date, race_date FROM track_calendar WHERE ins_id = 1
