import React, { useCallback, useEffect, useRef } from 'react';
import { debounce } from 'lodash';



const DateInputComponent = ({ blocks,selectedBlock, selectedRoom, data, blockDataSet, hasMax, hasMin, maximumDate, minimumDate, validationErrors, allErrors }) => {
    const blocksRef = useRef(blocks); // blocks'un güncel değerini tutmak için useRef kullanılıyor
    const blockDataSetRef = useRef(blockDataSet);
    useEffect(() => {
        console.log("asd");
      blocksRef.current = blocks; // blocks değiştikçe useRef güncelleniyor
      blockDataSetRef.current = blockDataSet;
    }, [blocks]);
    
    const debouncedMaxValidation = useCallback(debounce((date, maxDate, name) => {
        console.log(blocks);
        if (date > maxDate) {
          blockDataSetRef.current(
            selectedBlock,
            name,
            maxDate.getFullYear()+"-"+((maxDate.getMonth() + 1) < 10 ? "0"+(maxDate.getMonth() + 1) : (maxDate.getMonth() + 1)) +"-"+(maxDate.getDate() < 10 ? "0"+maxDate.getDate() : maxDate.getDate())
          );
        }
    }, 2000), []);
    
    const debouncedMinValidation = useCallback(debounce((date, minDate, name) => {
        if (date < minDate) {
            blockDataSetRef.current(
              selectedBlock,
              name,
              minDate.getFullYear()+"-"+((minDate.getMonth() + 1) < 10 ? "0"+(minDate.getMonth() + 1) : (minDate.getMonth() + 1)) +"-"+(minDate.getDate() < 10 ? "0"+minDate.getDate() : minDate.getDate())
            );
          }
    }, 2000), []);
  const handleChange = (e) => {
    const inputDate = e.target.value;

    if (inputDate.length === 10) {
      blockDataSet(selectedBlock, data?.name, inputDate);

      if (hasMax) {
        debouncedMaxValidation(new Date(inputDate), maximumDate, data?.name);
      }

      if (hasMin) {
        debouncedMinValidation(new Date(inputDate), minimumDate, data?.name);
      }
    }
  };

  return (
    <input
      id={data?.name.replace("[]", "")}
      type="date"
      min={hasMin ? minimumDate.toJSON().slice(0, 10) : ""}
      max={hasMax ? maximumDate.toJSON().slice(0, 10) : ""}
      value={
        blocks[selectedBlock]?.rooms[selectedRoom] &&
        blocks[selectedBlock]?.rooms[selectedRoom][data.name]
          ? blocks[selectedBlock]?.rooms[selectedRoom][data.name]
          : ""
      }
      onChange={handleChange}
      className={
        "form-control " +
        (validationErrors.includes(data?.name) ? "error-border" : "") +
        " " +
        (allErrors.includes(data?.name.replace("[]", "")) ? "error-border" : "")
      }
    />
  );
};

export default DateInputComponent;
