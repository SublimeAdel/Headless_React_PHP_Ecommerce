import React from "react";
import { AnimatePresence, motion } from "framer-motion";

const Notification = ({ notificationText }) => {
  return (
    <AnimatePresence>
      <motion.span
        key={notificationText}
        initial={{ opacity: 0 }}
        animate={{ opacity: 1, transition: { duration: 0.5 } }}
        exit={{ opacity: 0, transition: { duration: 0.3 } }}
      >
        <span className="notification">{notificationText}</span>
      </motion.span>
    </AnimatePresence>
  );
};

export default Notification;
