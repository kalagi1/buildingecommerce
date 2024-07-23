import React from 'react';
import './CustomModal.css'; // Özel stil dosyasını import edin

const CustomModal = ({ isOpen, onClose, children }) => {
  if (!isOpen) return null;

  return (
    <div className="custom-modal-overlay" onClick={onClose}>
      <div className="custom-modal-content" onClick={(e) => e.stopPropagation()}>
        {children}
      </div>
    </div>
  );
};

export default CustomModal;
