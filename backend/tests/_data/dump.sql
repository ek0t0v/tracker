--
-- PostgreSQL database dump
--

-- Dumped from database version 10.5 (Debian 10.5-1.pgdg90+1)
-- Dumped by pg_dump version 10.5 (Debian 10.5-1.pgdg90+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: migration_versions; Type: TABLE; Schema: public; Owner: symfony
--

CREATE TABLE public.migration_versions (
    version character varying(255) NOT NULL
);


ALTER TABLE public.migration_versions OWNER TO symfony;

--
-- Name: refresh_tokens; Type: TABLE; Schema: public; Owner: symfony
--

CREATE TABLE public.refresh_tokens (
    id integer NOT NULL,
    refresh_token character varying(128) NOT NULL,
    username character varying(255) NOT NULL,
    valid timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.refresh_tokens OWNER TO symfony;

--
-- Name: refresh_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: symfony
--

CREATE SEQUENCE public.refresh_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.refresh_tokens_id_seq OWNER TO symfony;

--
-- Name: tasks; Type: TABLE; Schema: public; Owner: symfony
--

CREATE TABLE public.tasks (
    id integer NOT NULL,
    name character varying(255) DEFAULT NULL::character varying,
    "position" integer NOT NULL,
    user_id integer
);


ALTER TABLE public.tasks OWNER TO symfony;

--
-- Name: tasks_id_seq; Type: SEQUENCE; Schema: public; Owner: symfony
--

CREATE SEQUENCE public.tasks_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tasks_id_seq OWNER TO symfony;

--
-- Name: timings; Type: TABLE; Schema: public; Owner: symfony
--

CREATE TABLE public.timings (
    id integer NOT NULL,
    task_id integer,
    started_at timestamp(0) without time zone NOT NULL,
    ended_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.timings OWNER TO symfony;

--
-- Name: timings_id_seq; Type: SEQUENCE; Schema: public; Owner: symfony
--

CREATE SEQUENCE public.timings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.timings_id_seq OWNER TO symfony;

--
-- Name: users; Type: TABLE; Schema: public; Owner: symfony
--

CREATE TABLE public.users (
    id integer NOT NULL,
    email character varying(255) NOT NULL,
    email_canonical character varying(255) NOT NULL,
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    roles json NOT NULL,
    enabled boolean NOT NULL,
    last_login timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    password_requested_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    created_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.users OWNER TO symfony;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: symfony
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO symfony;

--
-- Data for Name: migration_versions; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.migration_versions (version) FROM stdin;
20181102214131
20181103202224
20181108032357
20181110122836
\.


--
-- Data for Name: refresh_tokens; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.refresh_tokens (id, refresh_token, username, valid) FROM stdin;
\.


--
-- Data for Name: tasks; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.tasks (id, name, "position", user_id) FROM stdin;
1	Task 1	0	1
2	Task 2	1	1
3	Task 3	2	1
4	Task 4	3	1
\.


--
-- Data for Name: timings; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.timings (id, task_id, started_at, ended_at) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: symfony
--

COPY public.users (id, email, email_canonical, username, password, roles, enabled, last_login, password_requested_at, created_at) FROM stdin;
1	user@mail.ru	user@mail.ru	user	$2y$13$/SyqpMwe7vHj9s8BJhdCJuiHc6vCa3HkC0XyL8b4ojd2Z.NHyKaom	[]	t	\N	\N	2018-11-25 21:13:11
\.


--
-- Name: refresh_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.refresh_tokens_id_seq', 1, false);


--
-- Name: tasks_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.tasks_id_seq', 4, true);


--
-- Name: timings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.timings_id_seq', 1, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: symfony
--

SELECT pg_catalog.setval('public.users_id_seq', 1, true);


--
-- Name: migration_versions migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.migration_versions
    ADD CONSTRAINT migration_versions_pkey PRIMARY KEY (version);


--
-- Name: refresh_tokens refresh_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.refresh_tokens
    ADD CONSTRAINT refresh_tokens_pkey PRIMARY KEY (id);


--
-- Name: tasks tasks_pkey; Type: CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.tasks
    ADD CONSTRAINT tasks_pkey PRIMARY KEY (id);


--
-- Name: timings timings_pkey; Type: CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.timings
    ADD CONSTRAINT timings_pkey PRIMARY KEY (id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: idx_2cc5456d8db60186; Type: INDEX; Schema: public; Owner: symfony
--

CREATE INDEX idx_2cc5456d8db60186 ON public.timings USING btree (task_id);


--
-- Name: idx_50586597a76ed395; Type: INDEX; Schema: public; Owner: symfony
--

CREATE INDEX idx_50586597a76ed395 ON public.tasks USING btree (user_id);


--
-- Name: uniq_1483a5e9a0d96fbf; Type: INDEX; Schema: public; Owner: symfony
--

CREATE UNIQUE INDEX uniq_1483a5e9a0d96fbf ON public.users USING btree (email_canonical);


--
-- Name: uniq_1483a5e9e7927c74; Type: INDEX; Schema: public; Owner: symfony
--

CREATE UNIQUE INDEX uniq_1483a5e9e7927c74 ON public.users USING btree (email);


--
-- Name: uniq_9bace7e1c74f2195; Type: INDEX; Schema: public; Owner: symfony
--

CREATE UNIQUE INDEX uniq_9bace7e1c74f2195 ON public.refresh_tokens USING btree (refresh_token);


--
-- Name: timings fk_2cc5456d8db60186; Type: FK CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.timings
    ADD CONSTRAINT fk_2cc5456d8db60186 FOREIGN KEY (task_id) REFERENCES public.tasks(id);


--
-- Name: tasks fk_50586597a76ed395; Type: FK CONSTRAINT; Schema: public; Owner: symfony
--

ALTER TABLE ONLY public.tasks
    ADD CONSTRAINT fk_50586597a76ed395 FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- PostgreSQL database dump complete
--

