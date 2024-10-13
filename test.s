global _start

section .data
    reset_color db "\033[0m"  ; ANSI escape code to reset colors
    bg_red db "\033[41m"     ; ANSI escape code for red background color
    bg_green db "\033[42m"   ; ANSI escape code for green background color
    bg_yellow db "\033[43m"  ; ANSI escape code for yellow background color
    bg_blue db "\033[44m"    ; ANSI escape code for blue background color
    bg_magenta db "\033[45m" ; ANSI escape code for magenta background color
section .text

_start:
  mov rax, 1        ; write(
  mov rdi, 1        ;   STDOUT_FILENO,
  mov rsi, msg      ;   move message
  mov rdx, msglen   ;   sizeof('message')
  syscall           ; );

  mov rax, 60       ; exit(
  mov rdi, 0        ;   EXIT_SUCCESS
  syscall           ; );

    
section .rodata
  msg: db `\033[0;31mA\033[0;32ml\033[0;33me\033[0;34mx\033[0;35ma\033[0;36mn\033[0;37md\033[0;37me\033[0;38mr\033[0m`,10,0   
  msglen: equ $ - msg
